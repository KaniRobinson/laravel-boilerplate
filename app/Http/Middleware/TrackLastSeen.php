<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->user()) {
            return $response;
        }

        if ($request->user()->last_seen_at === null || $request->user()->last_seen_at->lte(now()->subMinute())) {
            $request->user()->forceFill(['last_seen_at' => now()])->saveQuietly();
        }

        return $response;
    }
}

