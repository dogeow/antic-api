<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * This middleware check if the request has _token key and adds this into the Authorization header to take advantage of
 * the sanctum middleware
 */
class CheckTokenAndAddToHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response|RedirectResponse|JsonResponse|BinaryFileResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse|BinaryFileResponse
    {
        if (property_exists($request, '_token') && $request->_token !== null) {
            $request->headers->set('Authorization', sprintf('%s %s', 'Bearer', $request->_token));
        }

        return $next($request);
    }
}
