<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{

    public function showLoginForm()
{
    return view('auth.login'); // make sure you have this view
}


    public function login(Request $request)
    {
        // ✅ If already logged in, redirect to dashboard (fix back button issue)
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('staff')->check()) {
            return redirect()->route('staff.dashboard');
        }

        // Validate form inputs
        $request->validate([
            'staff_id' => 'required',
            'password' => 'required',
        ]);

        // Find user by staff_id
        $user = User::where('staff_id', $request->staff_id)->first();

        // User not found
        if (!$user) {
            return back()->withErrors(['staff_id' => 'No user found with this Staff ID']);
        }

        // Password incorrect
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password']);
        }

        // Choose guard based on usertype
        $guard = ($user->usertype === 'admin') ? 'admin' : 'staff';

        // Attempt login on the correct guard
        if (Auth::guard($guard)->attempt([
            'staff_id' => $request->staff_id,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();

            if ($guard === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('staff.dashboard');
            }
        }

        return back()->withErrors(['password' => 'Incorrect password']);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            Session::forget('admin_session_' . Session::getId());
        }

        if (Auth::guard('staff')->check()) {
            Auth::guard('staff')->logout();
            Session::forget('staff_session_' . Session::getId());
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ After logout, redirect to login
        return redirect()->route('login');
    }
}
