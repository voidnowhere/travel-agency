<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function create()
    {
        return view('auth.verify-email');
    }

    public function store(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent!');
    }

    public function update(EmailVerificationRequest $request)
    {
        $request->fulfill();

        if ($request->user()->is_admin) {
            return redirect()->route('admin')->with('success', 'Email verified successfully.');
        }

        return redirect()->route('home')->with('success', 'Email verified successfully.');
    }
}
