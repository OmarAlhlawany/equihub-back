<?php

namespace App\Http\Middleware;

use Closure;

class ConvertEmptyStringsToNull
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
        // Convert empty strings to null before continuing the request
        array_walk_recursive($request->all(), function (&$input) {
            if ($input === '') {
                $input = null;
            }
        });

        return $next($request);
    }
}
