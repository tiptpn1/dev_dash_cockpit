<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * RestrictIpAccess Middleware
 *
 * Membatasi akses ke route berdasarkan IP whitelist.
 * Dipakai untuk endpoint mesin (mis. n8n) yang diakses via token, agar
 * tidak cukup hanya berbekal token — IP pemanggil juga harus terdaftar.
 *
 * Sumber daftar IP: config('security.api_allowed_ips') atau env API_ALLOWED_IPS
 * (dipisah koma). Mendukung: exact match, CIDR (10.0.0.0/24), wildcard (10.0.0.*),
 * dan variasi localhost.
 *
 * Catatan: bila whitelist KOSONG (belum dikonfigurasi), middleware ini
 * membiarkan request lewat (fail-open) supaya deploy tidak terkunci, namun
 * mencatat peringatan. Set API_ALLOWED_IPS di .env untuk mengaktifkan proteksi.
 */
class RestrictIpAccess
{
    public function handle(Request $request, Closure $next)
    {
        $allowedIps = $this->getAllowedIps();

        // Belum dikonfigurasi -> fail-open + warning agar tidak mengunci akses.
        if (empty($allowedIps)) {
            Log::warning('RestrictIpAccess: whitelist kosong, akses dibiarkan lewat.', [
                'ip' => $request->ip(),
                'path' => $request->path(),
            ]);
            return $next($request);
        }

        if (!$this->isIpAllowed($request->ip(), $allowedIps)) {
            Log::warning('RestrictIpAccess: IP tidak diizinkan.', [
                'ip' => $request->ip(),
                'path' => $request->path(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Access denied: IP not whitelisted',
                'your_ip' => $request->ip(),
            ], 403);
        }

        return $next($request);
    }

    /**
     * Ambil daftar IP yang diizinkan dari config/env.
     */
    protected function getAllowedIps(): array
    {
        $ips = config('security.api_allowed_ips', env('API_ALLOWED_IPS', ''));

        if (empty($ips)) {
            return [];
        }

        if (is_array($ips)) {
            return array_filter(array_map('trim', $ips));
        }

        return array_filter(array_map('trim', explode(',', $ips)));
    }

    /**
     * Cek apakah IP termasuk dalam whitelist (exact / localhost / CIDR / wildcard).
     */
    protected function isIpAllowed(string $ip, array $allowedIps): bool
    {
        $localhostVariations = ['127.0.0.1', '::1', 'localhost'];

        foreach ($allowedIps as $allowedIp) {
            if ($ip === $allowedIp) {
                return true;
            }

            if (in_array($allowedIp, $localhostVariations) && in_array($ip, $localhostVariations)) {
                return true;
            }

            if (str_contains($allowedIp, '/')) {
                if ($this->ipInRange($ip, $allowedIp)) {
                    return true;
                }
            }

            if (str_contains($allowedIp, '*')) {
                $pattern = '/^' . str_replace(['.', '*'], ['\.', '.*'], $allowedIp) . '$/';
                if (preg_match($pattern, $ip)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Cek apakah IP berada dalam rentang CIDR (IPv4).
     */
    protected function ipInRange(string $ip, string $cidr): bool
    {
        if (!str_contains($cidr, '/')) {
            return false;
        }

        list($subnet, $mask) = explode('/', $cidr);

        $ipLong = ip2long($ip);
        $subnetLong = ip2long($subnet);

        // ip2long gagal (mis. IPv6) -> tidak cocok.
        if ($ipLong === false || $subnetLong === false) {
            return false;
        }

        $maskLong = -1 << (32 - (int)$mask);

        return ($ipLong & $maskLong) === ($subnetLong & $maskLong);
    }
}
