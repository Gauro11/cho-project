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


}
