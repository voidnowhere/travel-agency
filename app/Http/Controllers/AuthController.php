<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

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
