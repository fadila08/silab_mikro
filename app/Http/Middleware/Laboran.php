<?php

namespace App\Http\Middleware;

use Closure;

class Laboran
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
        if ($request->user()->id_roles != 4 && $request->user()->id_roles != 6)
        {
            return response()->json(['error' => 'unauthorized'], 401);
        }
        else {
            return $next($request);
        }
    }
}
