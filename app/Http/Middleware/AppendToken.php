<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AppendToken
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->route()->getName() !== 'telescope') {
            return $response;
        }

        if ($request->cookie('token')) {
            return $response;
        }

        if (empty($token = $request->input('token'))) {
            return $response;
        }

        $token = PersonalAccessToken::findToken($token);

        if (! $token) {
            info("Error: Token not found");
        }

        $user = $token->tokenable;
        info($user->id);
        if (empty($user)) {
            return $response;
        }
        auth()->login($user);

        $response = $next($request);
        $response->withCookie(cookie('token', $token));

        return $response;
    }
}
