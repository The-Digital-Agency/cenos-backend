<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token is Expired'], 440); // Expired loggin status
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Token is Invalid'], 400); // Invalid loggin status
        } catch (JWTException $e) {
            return response()->json(['message' => 'Authorization Token not found'], 401); // Unauthorized status
        }

        return $next($request);
    }
}
