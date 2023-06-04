<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');
        
        if (!str_starts_with($authorizationHeader, 'Bearer ') ||
            !$this->validateToken($authorizationHeader)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

    /**
     * Check if the token satisfies the parentheses problem
     * 
     * @param string $token The token to validate
     * 
     * @return bool True if the token is valid, false otherwise
     */
    private function validateToken($token) {

        $token = substr($token, 7);

        while (strpos($token, '{}') !== false || strpos($token, '[]') !== false || strpos($token, '()') !== false) {
            $token = str_replace(['{}', '[]', '()'], '', $token);
        }
    
        return $token === '';
    }
    
}
