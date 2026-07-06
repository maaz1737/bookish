<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/**
 * Password-based login for Admin / Super Admin (customers use OTP).
 */
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('login');

Route::post('/admin/login', function (Request $request) {
    $creds = $request->validate([
        'mobile'   => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt($creds) && Auth::user()->isAdmin() && ! Auth::user()->is_blocked) {
        $request->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    }

    Auth::logout();
    return back()->withErrors(['mobile' => 'Invalid admin credentials.']);
})->name('admin.login.attempt');
