<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        $apiKey = $request->header('X-API-Key') ?: $request->query('api_key');

        if (!$apiKey) {
            return response()->json([
                'error' => 'API key is required. Provide it via X-API-Key header or api_key query parameter.'
            ], 401);
        }

        $key = ApiKey::where('key', $apiKey)
            ->where('is_active', true)
            ->first();

        if (!$key) {
            return response()->json([
                'error' => 'Invalid or inactive API key.'
            ], 401);
        }

        if ($permission && !$key->hasPermission($permission)) {
            return response()->json([
                'error' => 'API key does not have permission to access this endpoint.'
            ], 403);
        }

        // Update last used timestamp
        $key->updateLastUsed();

        // Add API key info to request
        $request->attributes->set('api_key', $key);
        $request->attributes->set('api_user', $key->user);

        return $next($request);
    }
}
