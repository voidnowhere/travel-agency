<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    public function create()
    {
        return view('home.change-password');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $newPassword = $this->validatePassword($request);

        $user->update([
            'password' => $newPassword,
        ]);

        Auth::logoutOtherDevices($newPassword);

        if ($user->is_admin) {
            return redirect()->route('admin')->with('success', 'Password changed successfully.');
        }

        return redirect()->route('home')->with('success', 'Password changed successfully.');
    }

    protected function validatePassword(Request $request)
    {
        $attributes = $request->validate([
            'password' => 'current_password',
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        return $attributes['new_password'];
    }
}
