<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CustomUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Puppeteer Authentication Controller
 * 
 * Handles authentication for Puppeteer automation scripts
 * Supports static token authentication for scheduled screenshots and captures
 */
class PuppeteerAuthController extends Controller
{
    /**
     * Authenticate Puppeteer with static token
     * 
     * GET /session-gateway?key=KEY&redirect=/overview
     * GET /session-gateway?key=KEY&username=superadmin
     *
     * Param 'key' adalah nama baru; 'token' tetap didukung untuk kompatibilitas mundur.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        // Terima 'key' (nama baru) atau 'token' (lama) untuk kompatibilitas mundur.
        $token = $request->query('key', $request->query('token'));
        $redirect = $request->query('redirect', '/');
        $username = $request->query('username', 'superadmin');
        
        // Validate token
        if (!$token) {
            Log::warning('Puppeteer auth: No token provided', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Key is required',
                'your_ip' => $request->ip(),
                'example' => url('/session-gateway') . '?key=YOUR_KEY&redirect=/overview',
            ], 400);
        }
        
        // Get expected token from env
        $expectedToken = config('puppeteer.auth_token', env('PUPPETEER_AUTH_TOKEN'));
        
        if (!$expectedToken) {
            Log::error('Puppeteer auth: PUPPETEER_AUTH_TOKEN not configured');
            
            return response()->json([
                'status' => 'error',
                'message' => 'Puppeteer authentication not configured',
            ], 500);
        }
        
        // Verify token
        if ($token !== $expectedToken) {
            Log::warning('Puppeteer auth: Invalid token', [
                'ip' => $request->ip(),
                'token_preview' => substr($token, 0, 10) . '...',
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid authentication token',
                'your_ip' => $request->ip(),
                'hint' => 'Check PUPPETEER_AUTH_TOKEN in .env file',
            ], 401);
        }
        
        // Check IP whitelist (optional)
        $allowedIps = $this->getAllowedIps();
        if (!empty($allowedIps) && !$this->isIpAllowed($request->ip(), $allowedIps)) {
            Log::warning('Puppeteer auth: IP not whitelisted', [
                'ip' => $request->ip(),
                'allowed_ips' => $allowedIps,
                'user_agent' => $request->userAgent(),
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied: IP not whitelisted',
                'details' => [
                    'your_ip' => $request->ip(),
                    'allowed_ips' => $allowedIps,
                ],
                'solution' => "Add '{$request->ip()}' to PUPPETEER_ALLOWED_IPS in .env file",
                'example' => 'PUPPETEER_ALLOWED_IPS=' . $request->ip() . ',' . implode(',', array_slice($allowedIps, 0, 2)),
            ], 403);
        }
        
        // Find user
        $user = CustomUser::where('username', $username)->first();
        
        if (!$user) {
            Log::error('Puppeteer auth: User not found', [
                'username' => $username,
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'User not found: ' . $username,
                'your_ip' => $request->ip(),
                'hint' => 'Check if user exists in custom_users table',
            ], 404);
        }
        
        // Create session
        Auth::guard('custom')->login($user, true);
        
        Log::info('Puppeteer auth: Success', [
            'username' => $username,
            'user_id' => $user->id,
            'ip' => $request->ip(),
            'redirect' => $redirect,
        ]);
        
        // Store metadata in session
        session([
            'puppeteer_auth' => true,
            'puppeteer_auth_at' => now()->toDateTimeString(),
            'puppeteer_auth_ip' => $request->ip(),
        ]);
        
        // Return based on request type
        if ($request->expectsJson() || $request->input('json')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Authentication successful',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'name' => $user->name,
                    ],
                    'redirect_url' => $redirect,
                ],
            ]);
        }
        
        // Redirect to requested page
        return redirect($redirect)->with('success', 'Authenticated via Puppeteer token');
    }
    
    /**
     * Verify Puppeteer session
     * 
     * GET /session-status
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $user = Auth::guard('custom')->user();
        $isPuppeteerSession = session('puppeteer_auth', false);
        $allowedIps = $this->getAllowedIps();
        $requestIp = $request->ip();
        $isIpAllowed = empty($allowedIps) || $this->isIpAllowed($requestIp, $allowedIps);
        
        return response()->json([
            'status' => 'ok',
            'authenticated' => Auth::guard('custom')->check(),
            'puppeteer_session' => $isPuppeteerSession,
            'your_ip' => $requestIp,
            'ip_allowed' => $isIpAllowed,
            'user' => $user ? [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
            ] : null,
            'session_data' => [
                'auth_at' => session('puppeteer_auth_at'),
                'auth_ip' => session('puppeteer_auth_ip'),
            ],
        ]);
    }
    
    /**
     * Logout Puppeteer session
     * 
     * POST /session-end
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $username = Auth::guard('custom')->user()?->username;
        
        Auth::guard('custom')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        Log::info('Puppeteer logout', [
            'username' => $username,
            'ip' => $request->ip(),
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful',
        ]);
    }
    
    /**
     * Health check for Puppeteer automation
     * 
     * GET /session-health
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function health()
    {
        $tokenConfigured = !empty(config('puppeteer.auth_token', env('PUPPETEER_AUTH_TOKEN')));
        $allowedIps = $this->getAllowedIps();
        $requestIp = request()->ip();
        $isIpAllowed = empty($allowedIps) || $this->isIpAllowed($requestIp, $allowedIps);
        
        return response()->json([
            'status' => 'ok',
            'service' => 'Puppeteer Authentication',
            'timestamp' => now()->toIso8601String(),
            'configured' => $tokenConfigured,
            'your_ip' => $requestIp,
            'ip_check' => [
                'allowed' => $isIpAllowed,
                'whitelist_enabled' => !empty($allowedIps),
                'allowed_ips' => $allowedIps,
                'hint' => $isIpAllowed ? 'Your IP is allowed' : 'Your IP is NOT in whitelist'
            ],
            'endpoints' => [
                'auth' => url('/session-gateway?key=KEY&redirect=/overview'),
                'verify' => url('/session-status'),
                'logout' => url('/session-end'),
                'health' => url('/session-health'),
            ],
        ]);
    }
    
    /**
     * Get allowed IPs from config
     * 
     * @return array
     */
    protected function getAllowedIps(): array
    {
        $ips = config('puppeteer.allowed_ips', env('PUPPETEER_ALLOWED_IPS', ''));
        
        if (empty($ips)) {
            return [];
        }
        
        if (is_array($ips)) {
            return $ips;
        }
        
        return array_map('trim', explode(',', $ips));
    }
    
    /**
     * Check if IP is allowed
     * 
     * @param string $ip
     * @param array $allowedIps
     * @return bool
     */
    protected function isIpAllowed(string $ip, array $allowedIps): bool
    {
        // Allow localhost variations
        $localhostVariations = ['127.0.0.1', '::1', 'localhost'];
        
        foreach ($allowedIps as $allowedIp) {
            // Exact match
            if ($ip === $allowedIp) {
                return true;
            }
            
            // Localhost check
            if (in_array($allowedIp, $localhostVariations) && in_array($ip, $localhostVariations)) {
                return true;
            }
            
            // CIDR notation support
            if (str_contains($allowedIp, '/')) {
                if ($this->ipInRange($ip, $allowedIp)) {
                    return true;
                }
            }
            
            // Wildcard support (e.g., 192.168.1.*)
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
     * Check if IP is in CIDR range
     * 
     * @param string $ip
     * @param string $cidr
     * @return bool
     */
    protected function ipInRange(string $ip, string $cidr): bool
    {
        list($subnet, $mask) = explode('/', $cidr);
        
        $ipLong = ip2long($ip);
        $subnetLong = ip2long($subnet);
        $maskLong = -1 << (32 - (int)$mask);
        
        return ($ipLong & $maskLong) === ($subnetLong & $maskLong);
    }
}
