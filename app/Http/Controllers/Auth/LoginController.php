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

        // Login with default guard
        Auth::login($user);

        // Regenerate session for security
        $request->session()->regenerate();

        // Redirect based on usertype
        if ($user->usertype === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('staff.dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
