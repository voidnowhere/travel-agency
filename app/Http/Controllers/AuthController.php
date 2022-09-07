<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function create()
    {
        return view('home.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => ['required', Password::defaults()],
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $throttleKey = Str::transliterate($credentials['email'] . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $availableIn = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in $availableIn seconds.",
            ])->onlyInput('email');
        }

        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($throttleKey);

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        RateLimiter::clear($throttleKey);

        $user = Auth::user();

        if (Hash::needsRehash($user->password)) {
            $user->update([
                'password' => $credentials['password'],
            ]);
        }

        $request->session()->regenerate();

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')->with('success', 'Successful login.');
        }

        if ($user->is_admin) {
            return redirect()->intended(route('admin'))->with('success', 'Successful login.');
        }

        return redirect()->intended(route('home'))->with('success', 'Successful login.');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Successful logout.');
    }
}
