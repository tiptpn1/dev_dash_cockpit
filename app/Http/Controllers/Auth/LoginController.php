<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomUser;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // dd($request->input('g-recaptcha-response'));
        // 6LdawH8qAAAAAPj8NAU8pUZbU5BEzRbqYfkNozAu
        $credentials = $request->only('username', 'password');
        if($request->input('g-recaptcha-response')==""){
            return back()->withErrors([
             'username' => 'reCaptcha untuk di isi'
             ]);
        }
        if (Auth::guard('custom')->attempt($credentials) ) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Username dan Password Salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('custom')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}