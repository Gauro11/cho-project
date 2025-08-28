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




  public function loginAdmin(Request $request)
{
    return $this->loginByGuard($request, 'admin', 'admin.dashboard');
}

public function loginStaff(Request $request)
{
    return $this->loginByGuard($request, 'staff', 'staff.dashboard');
}

private function loginByGuard(Request $request, $guard, $redirectRoute)
{
    $request->validate([
        'staff_id' => 'required',
        'password' => 'required',
    ]);

    $user = User::where('staff_id', $request->staff_id)->first();

    if (!$user || !\Hash::check($request->password, $user->password)) {
        return back()->withErrors(['staff_id' => 'Invalid credentials']);
    }

    // Attempt login using the correct guard
    if (Auth::guard($guard)->attempt([
        'staff_id' => $request->staff_id,
        'password' => $request->password
    ])) {
        $request->session()->regenerate();
        return redirect()->route($redirectRoute);
    }

    return back()->withErrors(['staff_id' => 'Invalid credentials']);
}

public function logoutAdmin(Request $request)
{
    Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
}

public function logoutStaff(Request $request)
{
    Auth::guard('staff')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('staff.login');
}



}
