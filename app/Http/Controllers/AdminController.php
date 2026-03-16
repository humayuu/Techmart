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
use Yajra\DataTables\Facades\DataTables;

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

            $admin = Auth::guard('admin')->user();

            if ($admin->status === 'active') {
                $request->session()->regenerate();

                return redirect()->route('admin.dashboard');
            }
            Auth::guard('admin')->logout();

            return redirect()->route('admin.login.page')->withErrors([
                'email' => 'Your account is inactive.',
            ])->withInput($request->only('email'));
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

    // Mark single notification as read
    public function markNotificationRead($id)
    {
        $notification = auth('admin')->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    // Mark all notifications as read
    public function markAllNotificationsRead()
    {
        auth('admin')->user()
            ->unreadNotifications
            ->markAsRead();

        return response()->json(['success' => true]);
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

    // ======================= For Manage Admin User =========================
    /**
     * For Redirect to All Admin user page
     */
    public function adminUser(Request $request)
    {
        $adminUser = Admin::where('id', '!=', 1)->orderBy('id', 'DESC');

        if ($request->ajax()) {
            return DataTables::of($adminUser)
                ->addColumn('image', function ($row) {
                    $imageUrl = $row->profile_image
                        ? asset('images/profile_image/'.$row->profile_image)
                        : asset('default-avatar.png');

                    return '
                    <div class="d-flex justify-content-center">
                        <img src="'.$imageUrl.'" alt="Avatar"
                            class="img-thumbnail object-fit-cover border"
                            width="100" height="90">
                    </div>';
                })
                ->addColumn('role', function ($row) {
                    $color = $row->role === 'admin' ? 'primary' : 'dark';
                    $label = ucwords(str_replace('_', ' ', $row->role));

                    return '<span class="badge fs-6 bg-'.$color.' px-3 py-2">'.$label.'</span>';
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 'active'
                        ? '<span class="badge fs-6 bg-success px-3 py-2">Active</span>'
                        : '<span class="badge fs-6 bg-danger px-3 py-2">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.user.edit', $row->id);
                    $deleteUrl = route('admin.user.destroy', $row->id);
                    $statusUrl = route('admin.user.status', $row->id);
                    $detailUrl = route('admin.user.show', $row->id);
                    $class = $row->status == 'active' ? 'success' : 'dark';
                    $icon = $row->status == 'active' ? 'thumbs-up' : 'thumbs-down';
                    $title = $row->status == 'active' ? 'Deactivate' : 'Activate';

                    return '
                    <div class="d-flex justify-content-center align-items-center gap-3 fs-5">

                        <a href="'.$detailUrl.'" class="text-secondary"
                           data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Info">
                            <i class="bi bi-eye-fill"></i>
                        </a>

                        <a href="'.$editUrl.'" class="text-primary"
                           data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Info">
                            <i class="bi bi-pencil-fill"></i>
                        </a>

                        <a href="'.$statusUrl.'" class="text-'.$class.'"
                           data-bs-toggle="tooltip" data-bs-placement="bottom" title="'.$title.'">
                            <i class="bi bi-hand-'.$icon.'-fill"></i>
                        </a>

                        <form method="POST" action="'.$deleteUrl.'" class="d-inline m-0 delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button id="delete" type="submit"
                                class="text-danger border-0 bg-transparent p-0 d-inline-flex align-items-center delete-btn"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"
                                style="cursor: pointer; line-height: 1; font-size: inherit;">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>

                    </div>';
                })
                ->rawColumns(['image', 'role', 'status', 'action'])
                ->make(true);
        }

        $totalAdminUsers = Admin::count();

        return view('admin.admin_user.index', compact('totalAdminUsers'));
    }

    /**
     * For Redirect to admin user create form
     */
    public function adminUserCreate()
    {
        return view('admin.admin_user.create');
    }

    /**
     * For Admin user store
     */
    public function adminUserStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,normal_user',
            'status' => 'required|in:active,inactive',
            'profile_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'access' => 'required',
        ]);

        try {
            $manager = new ImageManager(new Driver);
            // Create Upload Directory
            $UploadDir = public_path('images/profile_image');
            if (! is_dir($UploadDir)) {
                mkdir($UploadDir, 0755, true);
            }

            $fileName = null;

            // Upload user image with Resize
            if ($img = $request->file('profile_image')) {
                $fileName = uniqid('user_').'.'.$img->getClientOriginalExtension();

                $manager = new ImageManager(new Driver);
                $manager->read($img)
                    ->coverDown(200, 200)
                    ->save($UploadDir.'/'.$fileName);
            }

            Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role,
                'status' => $request->status,
                'profile_image' => $fileName,
                'access' => $request->access,
            ]);

            return redirect()->back()->with([
                'message' => 'Admin User Created Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            return redirect()->back()->with([
                'message' => 'Error in creating Admin user '.$e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     * For Redirect to Admin user Edit Form
     */
    public function adminUserEdit($id)
    {
        $adminUser = Admin::findOrFail($id);

        return view('admin.admin_user.edit', compact('adminUser'));
    }

    /**
     * For Admin user Update
     */
    public function adminUserUpdate(Request $request, $id)
    {
        $adminUser = Admin::findOrFail($id);
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email',
            'role' => 'required|in:admin,normal_user',
            'access' => 'required',
        ]);

        try {
            $adminUser->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'access' => $request->access,
            ]);

            return redirect()->back()->with([
                'message' => 'User Updated Successfully',
                'alert-type' => 'success',
            ]);

        } catch (Exception $e) {
            return redirect()->back()->with([
                'message' => 'Error in update Admin user '.$e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     * For Admin user Delete
     */
    public function adminUserDelete($id)
    {
        try {
            $adminUser = Admin::findOrFail($id);
            $userImage = $adminUser->profile_image;
            $adminUser->delete();

            // Unlink User Image
            if ($userImage && file_exists(public_path('images/profile_image/'.$userImage))) {
                unlink(public_path('images/profile_image/'.$userImage));
            }

            return redirect()->back()->with([
                'message' => 'User Deleted Successfully',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with([
                'message' => 'Error in delete Admin user '.$e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     * For Update Admin User Status
     */
    public function adminUserStatus($id)
    {
        try {
            $adminUser = Admin::findOrFail($id);
            $newStatus = $adminUser->status == 'active' ? 'inactive' : 'active';
            $adminUser->update(['status' => $newStatus]);

            return redirect()->back()->with([
                'message' => 'Status Updated Successfully',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with([
                'message' => 'Error in update user status '.$e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     * For Show Admin user Detail
     */
    public function adminUserShow($id)
    {
        $adminUser = Admin::findOrFail($id);

        return view('admin.admin_user.show', compact('adminUser'));
    }
}
