<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
