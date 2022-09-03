<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\AlphaNumOneSpaceBetween;
use App\Rules\AlphaOneSpaceBetween;
use Illuminate\Auth\Events\Registered;
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
        $user = User::create($this->validateUser($request));

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Registered successfully.');
    }

    protected function validateUser(Request $request)
    {
        $attributes = $request->validate([
            'city' => 'required|exists:cities,id',
            'last_name' => ['required', new AlphaOneSpaceBetween],
            'first_name' => ['required', new AlphaOneSpaceBetween],
            'address' => ['required', new AlphaNumOneSpaceBetween],
            'phone_number' => 'required|numeric',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $attributes['city_id'] = $attributes['city'];

        return $attributes;
    }
}
