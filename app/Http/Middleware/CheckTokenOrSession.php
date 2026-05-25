<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomUser;

/**
 * CheckTokenOrSession Middleware
 *
 * Memvalidasi akses via static token di URL (?token=xxx)
 * atau fallback ke session login biasa (auth:custom).
 *
 * Cara penggunaan:
 *   Akses dengan token  : /evaluasi-aplikasi?token=ptpn1-hris-eval-2024-secret
 *   Akses dengan session: login biasa kemudian kunjungi /evaluasi-aplikasi
 */
class CheckTokenOrSession
{
    /**
     * Daftar token statis yang diizinkan.
     * Format: 'token_string' => 'nama_sumber / keterangan'
     *
     * Ganti atau tambahkan token sesuai kebutuhan.
     */
    protected array $validTokens = [
        'ptpn1-hris-eval-2024-xK9mPqRs' => 'HRIS Dashboard (permanent)',
        'agrinav-cockpit-token-LzW3nYvB' => 'Agrinav Integration (permanent)',
    ];

    public function handle(Request $request, Closure $next)
    {
        // --- 1. Cek apakah ada ?token= di URL ---
        if ($request->has('token')) {
            $token = $request->get('token');

            if (array_key_exists($token, $this->validTokens)) {
                // Token valid → login sebagai user "token_user" jika belum login
                if (!Auth::guard('custom')->check()) {
                    // Cari atau buat user khusus untuk akses token
                    $tokenUser = CustomUser::where('username', 'token_access_user')->first();

                    if ($tokenUser) {
                        Auth::guard('custom')->login($tokenUser, false);
                    }
                    // Jika user token_access_user tidak ada di DB,
                    // kita tetap izinkan akses dengan menyimpan token ke session
                    session(['token_access_granted' => true, 'token_source' => $this->validTokens[$token]]);
                }

                // Simpan token ke session agar sub-route (/hris-data, dll) tetap bisa diakses
                session(['url_token' => $token, 'url_token_valid' => true]);

                return $next($request);
            }

            // Token ada tapi tidak valid
            abort(403, 'Token tidak valid. Akses ditolak.');
        }

        // --- 2. Cek session token yang sudah divalidasi sebelumnya ---
        if (session('url_token_valid') === true) {
            return $next($request);
        }

        // --- 3. Fallback: cek session login biasa (auth:custom) ---
        if (Auth::guard('custom')->check()) {
            return $next($request);
        }

        // --- 4. Tidak ada token dan tidak login → redirect ke login ---
        return redirect()->route('login')
            ->with('error', 'Silakan login atau gunakan link dengan token yang valid.');
    }
}
