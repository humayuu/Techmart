<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AdminController extends Controller
{
    /**
     *  Function for Redirect to Admin login page
     */
    public function AdminLogin()
    {
        return view('admin.login');
    }

    /**
     * Admin Logged In
     */
    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login.page')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Function for Redirect to Admin Dashboard page
     */
    public function AdminDashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Function Admin logout
     */
    public function AdminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

        // $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Logout Successfully',
        ];

        return redirect()->route('admin.login.page')->with($notification);
    }

    /**
     * Function for Redirect to Admin user Profile Detail
     */
    public function AdminProfileDetail()
    {
        $user = Auth::guard('admin')->user();

        return view('admin.profile', compact('user'));
    }

    /**
     * For Update User info
     */
    public function AdminProfileUpdate(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:admins,email,'.Auth::guard('admin')->id(),
            'profile_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        try {
            $UploadDir = public_path('images/profile_image');

            if (! is_dir($UploadDir)) {
                mkdir($UploadDir, 0755, true);
            }

            $fileName = $user->profile_image;

            if ($request->hasFile('profile_image')) {
                $img = $request->file('profile_image');
                $fileName = uniqid('user_').'.'.$img->getClientOriginalExtension();

                $manager = new ImageManager(new Driver);
                $manager->read($img)
                    ->coverDown(200, 200)
                    ->save($UploadDir.'/'.$fileName);

                if ($user->profile_image && file_exists($UploadDir.'/'.$user->profile_image)) {
                    unlink($UploadDir.'/'.$user->profile_image);
                }
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'profile_image' => $fileName,
            ]);

            return redirect()->back()->with([
                'message' => 'Detail Updated Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in update profile details: '.$e->getMessage());
            if (isset($fileName) && $fileName !== $user->profile_image) {
                if (file_exists($UploadDir.'/'.$fileName)) {
                    unlink($UploadDir.'/'.$fileName);
                }
            }

            return redirect()->back()->with([
                'message' => 'Error in update profile',
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     * Function for Redirect to Admin user
     * Change Password Page
     */
    public function AdminChangePassword()
    {
        return view('admin.change_password');
    }

    /**
     * Function for Update Admin user password
     */
    public function AdminPasswordUpdate(Request $request)
    {
        $auth = Auth::guard('admin')->user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if (! Hash::check($request->current_password, $auth->password)) {
            return redirect()->back()->with([
                'message' => 'Wrong Current Passsword',
                'alert-type' => 'error',
            ]);
        }

        try {
            $auth->update([
                'password' => $request->password,
            ]);

            return redirect()->back()->with([
                'message' => 'Password Update Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('Error in update Password '.$e->getMessage());

            return redirect()->back()->with([
                'message' => 'Error in update Password',
                'alert-type' => 'error',
            ]);
        }
    }
}
