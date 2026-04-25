<?php

namespace App\Http\Middleware;

use App\Models\UserAccount;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentPasswordIsUpdated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('student.password.edit', 'student.password.update')) {
            return $next($request);
        }

        $user = UserAccount::query()->find($request->session()->get('user_account_id'));

        if ($user?->role === 'student' && $user->password_changed_at === null) {
            return redirect()->route('student.password.edit');
        }

        return $next($request);
    }
}
