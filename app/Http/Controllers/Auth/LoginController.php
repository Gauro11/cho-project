<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
 use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{




  public function login(Request $request)
{
    // Validate form inputs
    $request->validate([
        'staff_id' => 'required',
        'password' => 'required',
    ]);

    // Find user by staff_id
    $user = User::where('staff_id', $request->staff_id)->first();

    if (!$user) {
        return back()->withErrors(['staff_id' => 'No user found with this Staff ID']);
    }

    // Check password
    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'Incorrect password']);
    }

    // Attempt login using default 'web' guard
    $credentials = $request->only('staff_id', 'password');
    if (Auth::attempt($credentials)) {
        // Regenerate session to prevent fixation
        $request->session()->regenerate();

        // Redirect based on usertype using ternary operator
        return redirect()->route(Auth::user()->usertype === 'admin' ? 'admin.dashboard' : 'staff.dashboard');
    }

    return back()->withErrors(['password' => 'Incorrect password']);
}



    public function logout(Request $request)
{
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    }

    if (Auth::guard('staff')->check()) {
        Auth::guard('staff')->logout();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login'); // change to your login route
}



}
