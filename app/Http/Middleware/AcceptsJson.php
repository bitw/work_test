<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcceptsJson
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->add(['Accept' => 'application/json']);

        return $next($request);
    }
}
