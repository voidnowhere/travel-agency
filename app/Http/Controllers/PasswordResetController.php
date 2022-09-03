<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;

class PasswordResetController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email:rfc,dns']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function index($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => $password]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
