<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        $token  = $request->cookie('token');
        // dd($token);

        $result = JWTToken::verifyToken($token);
        if ($result == 'unauthorize') {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorize'
            ], status: 401);
        } else {
            $request->headers->set('email', $result);
            return $next($request);
        }
    }
}
