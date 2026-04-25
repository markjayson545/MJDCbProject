<?php

namespace App\Http\Middleware\Archived;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PromotionMW
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        echo "<h2 class='flex justify-center p-2 mt-5 bg-red-400 items-center content-center'>50% off on all items</h2><br>";

        return $next($request);
    }
}
