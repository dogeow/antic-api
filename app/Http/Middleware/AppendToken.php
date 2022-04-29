<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

        $user = $request->user();
        if (empty($user)) {
            return $response;
        }

        $response = $next($request);
        $response->withCookie(cookie('token', $token));

        return $response;
    }
}
