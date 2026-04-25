<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RouteGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentPath = trim($request->path(), '/');
        $userRole = (string) $request->session()->get('user_account_role');

        if ($userRole === 'student' && Str::startsWith($currentPath, 'admin')) {
            abort(403);
        }

        if ($userRole === 'admin' && Str::startsWith($currentPath, 'student')) {
            abort(403);
        }

        return $next($request);
    }
}
