<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('home.register');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|alpha',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create($attributes);

        return redirect()->route('login')->with('success', 'Registered Successfully');
    }
}
