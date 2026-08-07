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
     * GET /puppet-auth?token=TOKEN&redirect=/overview
     * GET /puppet-auth?token=TOKEN&username=superadmin
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $token = $request->query('token');
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
                'message' => 'Token is required',
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
            ], 401);
        }
        
        // Check IP whitelist (optional)
        $allowedIps = $this->getAllowedIps();
        if (!empty($allowedIps) && !$this->isIpAllowed($request->ip(), $allowedIps)) {
            Log::warning('Puppeteer auth: IP not whitelisted', [
                'ip' => $request->ip(),
                'allowed_ips' => $allowedIps,
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied: IP not whitelisted',
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
     * GET /puppet-verify
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $user = Auth::guard('custom')->user();
        $isPuppeteerSession = session('puppeteer_auth', false);
        
        return response()->json([
            'status' => 'ok',
            'authenticated' => Auth::guard('custom')->check(),
            'puppeteer_session' => $isPuppeteerSession,
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
     * POST /puppet-logout
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
     * GET /puppet-health
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function health()
    {
        $tokenConfigured = !empty(config('puppeteer.auth_token', env('PUPPETEER_AUTH_TOKEN')));
        
        return response()->json([
            'status' => 'ok',
            'service' => 'Puppeteer Authentication',
            'timestamp' => now()->toIso8601String(),
            'configured' => $tokenConfigured,
            'allowed_ips' => $this->getAllowedIps(),
            'endpoints' => [
                'auth' => url('/puppet-auth?token=TOKEN&redirect=/overview'),
                'verify' => url('/puppet-verify'),
                'logout' => url('/puppet-logout'),
                'health' => url('/puppet-health'),
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
