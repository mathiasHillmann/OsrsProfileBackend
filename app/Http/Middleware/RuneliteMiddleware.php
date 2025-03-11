<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RuneliteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        if ($request->userAgent() !== 'RuneLite') {
            return response('Unauthorized', 403);
        }

        return $next($request);
    }
}
