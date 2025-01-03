<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $pass = Auth::guard('sanctum')->check();

        if (!$token || !$pass) {
            return response()->json([
                'message' => 'Token not exists or wrong, please login or check first'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
