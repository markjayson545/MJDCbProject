<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LogServerErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $response = $next($request);
        } catch (Throwable $throwable) {
            $this->logServerError($request, Response::HTTP_INTERNAL_SERVER_ERROR, $throwable);

            throw $throwable;
        }

        if ($response->getStatusCode() >= Response::HTTP_INTERNAL_SERVER_ERROR) {
            $this->logServerError($request, $response->getStatusCode());
        }

        return $response;
    }

    private function logServerError(Request $request, int $statusCode, ?Throwable $throwable = null): void
    {
        $route = $request->route();

        $context = array_filter([
            'status' => $statusCode,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'path' => $request->path(),
            'route' => $route?->getName() ?? $route?->uri(),
            'ip' => $request->ip(),
            'user_id' => $request->user()?->getAuthIdentifier(),
            'request_id' => $request->headers->get('X-Request-Id'),
            'exception' => $throwable,
            'exception_class' => $throwable ? $throwable::class : null,
            'exception_message' => $throwable?->getMessage(),
        ], fn (mixed $value): bool => $value !== null);

        Log::error('Server error response returned.', $context);
    }
}
