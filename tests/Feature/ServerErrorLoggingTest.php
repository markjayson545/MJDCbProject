<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

it('logs 500 responses with request context', function () {
    Log::spy();

    Route::get('/__test/server-error-response', fn () => response('Broken', 500))
        ->name('test.server-error-response');

    $this->get('/__test/server-error-response', [
        'X-Request-Id' => 'render-request-123',
    ])->assertServerError();

    Log::shouldHaveReceived('error')
        ->once()
        ->withArgs(fn (string $message, array $context): bool => $message === 'Server error response returned.'
            && $context['status'] === 500
            && $context['method'] === 'GET'
            && $context['path'] === '__test/server-error-response'
            && $context['route'] === 'test.server-error-response'
            && $context['request_id'] === 'render-request-123');
});
