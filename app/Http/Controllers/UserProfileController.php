<?php

namespace App\Http\Controllers;

use App\Rules\AlphaNumOneSpaceBetween;
use App\Rules\AlphaOneSpaceBetween;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('home.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $user->update($this->validateUser($request));

        if ($user->wasChanged('email')) {
            $user->email_verified_at = null;
            $user->save();

            event(new Registered($user));
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    protected function validateUser(Request $request)
    {
        $attributes = $request->validate([
            'city' => 'required|exists:cities,id',
            'last_name' => ['required', new AlphaOneSpaceBetween],
            'first_name' => ['required', new AlphaOneSpaceBetween],
            'address' => ['required', new AlphaNumOneSpaceBetween],
            'phone_number' => 'required|numeric',
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users')->ignore($request->user()->email, 'email')
            ],
            'password' => 'current_password',
        ]);

        $attributes['city_id'] = $attributes['city'];

        return $attributes;
    }
}
