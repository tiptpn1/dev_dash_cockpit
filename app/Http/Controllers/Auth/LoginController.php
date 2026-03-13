<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required',
        ]);

        $expected = $request->session()->get('svg_captcha');
        $given = $request->input('captcha');
        if (!$expected || !$given || Str::lower($given) !== Str::lower($expected)) {
            return back()->withErrors([
                'captcha' => 'Kode keamanan tidak sesuai.',
            ])->withInput($request->only('username'));
        }

        $credentials = $request->only('username', 'password');

        if (Auth::guard('custom')->attempt($credentials)) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Username dan Password Salah',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::guard('custom')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function svgCaptcha(Request $request)
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $length = 5;
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $request->session()->put('svg_captcha', $code);

        $w = 130;
        $h = 44;
        $bg = '#0f172a';
        $txt = '#e5e7eb';
        $noise = '#1f2937';

        $letters = str_split($code);
        $xStep = $w / (count($letters) + 1);

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="'.$w.'" height="'.$h.'" viewBox="0 0 '.$w.' '.$h.'">';
        $svg .= '<rect width="100%" height="100%" fill="'.$bg.'"/>';
        for ($i = 0; $i < 6; $i++) {
            $x1 = random_int(0, $w);
            $y1 = random_int(0, $h);
            $x2 = random_int(0, $w);
            $y2 = random_int(0, $h);
            $opacity = mt_rand(15, 35) / 100;
            $svg .= '<line x1="'.$x1.'" y1="'.$y1.'" x2="'.$x2.'" y2="'.$y2.'" stroke="'.$noise.'" stroke-width="1" opacity="'.$opacity.'"/>';
        }
        foreach ($letters as $i => $ch) {
            $x = ($i + 1) * $xStep + random_int(-3, 3);
            $y = $h / 2 + random_int(6, 10);
            $rotate = random_int(-18, 18);
            $svg .= '<text x="'.$x.'" y="'.$y.'" fill="'.$txt.'" font-family="monospace" font-size="20" font-weight="700" text-anchor="middle" transform="rotate('.$rotate.' '.$x.' '.$y.')">'.$ch.'</text>';
        }
        $svg .= '</svg>';

        return response($svg, 200)->header('Content-Type', 'image/svg+xml');
    }
}