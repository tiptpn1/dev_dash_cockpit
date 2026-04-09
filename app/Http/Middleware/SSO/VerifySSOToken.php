<?php

namespace App\Http\Middleware\SSO;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SSO\SSOService;
use Exception;

/**
 * Verify SSO Token Middleware
 * 
 * Validates SSO token from request and creates session
 * Supports both User and CustomUser models
 */
class VerifySSOToken
{
    protected $ssoService;

    public function __construct(SSOService $ssoService)
    {
        $this->ssoService = $ssoService;
    }

    public function handle(Request $request, Closure $next)
    {
        // Check if already authenticated
        if (Auth::check()) {
            return $next($request);
        }

        // Get token from header or cookie
        $token = $this->getToken($request);

        if (!$token) {
            // No token found, continue (let other guards handle)
            return $next($request);
        }

        try {
            // Validate token with SSO Server
            $userData = $this->ssoService->validateToken($token);

            // Create user session based on config
            $this->createUserSession($userData, $token);

            // Store token in request for later use
            $request->attributes->set('sso_token', $token);
            $request->attributes->set('sso_user', $userData);

        } catch (Exception $e) {
            // Token validation failed, continue without session
            \Log::warning('SSO Token invalid in middleware', [
                'error' => $e->getMessage(),
            ]);
        }

        return $next($request);
    }

    /**
     * Extract SSO token from request
     */
    protected function getToken(Request $request): ?string
    {
        // Check Bearer token in Authorization header
        if ($request->bearerToken()) {
            return $request->bearerToken();
        }

        // Check SSO token in cookie
        if ($request->hasCookie('sso_token')) {
            return $request->cookie('sso_token');
        }

        // Check X-SSO-Token header
        if ($request->header('X-SSO-Token')) {
            return $request->header('X-SSO-Token');
        }

        return null;
    }

    /**
     * Create user session in local database
     */
    protected function createUserSession(array $userData, string $token): void
    {
        $userModel = config('sso.user_model', 'users');
        $guards = config('sso.guards', ['web']);

        foreach ($guards as $guard) {
            try {
                if ($userModel === 'custom') {
                    $this->loginCustomUser($userData, $token, $guard);
                } else {
                    $this->loginUser($userData, $token, $guard);
                }

                // Successfully logged in to this guard
                break;
            } catch (Exception $e) {
                \Log::warning("Failed to login user with guard: {$guard}", [
                    'error' => $e->getMessage(),
                ]);
                continue;
            }
        }
    }

    /**
     * Login as User (standard model)
     */
    protected function loginUser(array $userData, string $token, string $guard): void
    {
        $user = \App\Models\User::firstOrCreate(
            ['nik' => $userData['nik']],
            [
                'name' => $userData['name'] ?? '',
                'email' => $userData['email'] ?? '',
                'phone' => $userData['phone'] ?? '',
            ]
        );

        // Update user data from SSO
        $user->update([
            'name' => $userData['name'] ?? $user->name,
            'email' => $userData['email'] ?? $user->email,
            'phone' => $userData['phone'] ?? $user->phone,
            'role' => $userData['role'] ?? 'user',
        ]);

        // Store SSO token in session
        session(['sso_token' => $token, 'sso_data' => $userData]);

        Auth::guard($guard)->login($user, true);
    }

    /**
     * Login as CustomUser
     */
    protected function loginCustomUser(array $userData, string $token, string $guard): void
    {
        $user = \App\Models\CustomUser::firstOrCreate(
            ['nik' => $userData['nik']],
            [
                'name' => $userData['name'] ?? '',
                'email' => $userData['email'] ?? '',
                'phone' => $userData['phone'] ?? '',
            ]
        );

        // Update user data from SSO
        $user->update([
            'name' => $userData['name'] ?? $user->name,
            'email' => $userData['email'] ?? $user->email,
            'phone' => $userData['phone'] ?? $user->phone,
            'role' => $userData['role'] ?? 'user',
        ]);

        // Store SSO token in session
        session(['sso_token' => $token, 'sso_data' => $userData]);

        Auth::guard($guard)->login($user, true);
    }
}
