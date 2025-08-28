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




    public function login(Request $request)
{
    $request->validate([
        'staff_id' => 'required',
        'password' => 'required',
    ]);

    $user = User::where('staff_id', $request->staff_id)->first();

    if (!$user) {
        return back()->withErrors(['staff_id' => 'No user found with this Staff ID']);
    }

    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'Incorrect password']);
    }

    $guard = ($user->usertype === 'admin') ? 'admin' : 'staff';

    // Set custom session name per guard
    Session::setId($guard . '_session_' . Session::getId());

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

    return redirect()->route('login');
}




}
