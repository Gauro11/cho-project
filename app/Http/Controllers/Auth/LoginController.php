<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('staff_id', $request->staff_id)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['staff_id' => 'Invalid credentials']);
        }

        $guard = ($user->usertype === 'admin') ? 'admin' : 'staff';

        // Only attempt login for the guard of this user
        if (Auth::guard($guard)->attempt([
            'staff_id' => $request->staff_id,
            'password' => $request->password
        ])) {
            // regenerate session for this guard only
            $request->session()->regenerate();

            return ($guard === 'admin') 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('staff.dashboard');
        }

        return back()->withErrors(['staff_id' => 'Login failed']);
    }

    public function logout(Request $request, $guard = null)
    {
        // If guard specified, logout only that guard
        if ($guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
        } else {
            // Logout both guards
            if (Auth::guard('admin')->check()) {
                Auth::guard('admin')->logout();
            }

            if (Auth::guard('staff')->check()) {
                Auth::guard('staff')->logout();
            }

            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login');
    }
}
