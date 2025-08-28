<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

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

        // Decide guard
        $guard = $user->usertype === 'admin' ? 'admin' : 'staff';

        // Change session cookie for this guard before login
        Config::set('session.cookie', $guard . '_session');

        // Login user into correct guard
        Auth::guard($guard)->login($user);

        // Regenerate this session
        $request->session()->regenerate();

        // Redirect to the proper dashboard
        return $guard === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('staff.dashboard');
    }

    public function logout(Request $request, $guard = null)
    {
        if ($guard) {
            Auth::guard($guard)->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } else {
            if (Auth::guard('admin')->check()) Auth::guard('admin')->logout();
            if (Auth::guard('staff')->check()) Auth::guard('staff')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login');
    }
}
