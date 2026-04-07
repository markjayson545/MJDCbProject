<?php

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

test('alert component uses scoped icon class without oversized utility classes', function () {
    $html = view('student_mgmt.components.alerts', [
        'success' => 'Saved successfully.',
        'errors' => new ViewErrorBag,
    ])->render();

    expect($html)
        ->toContain('mjdc-alert-icon')
        ->not->toContain('size-min')
        ->not->toContain('min-w-min')
        ->not->toContain('min-h-min');
});

test('alert component still renders validation errors', function () {
    $errors = (new ViewErrorBag)->put('default', new MessageBag([
        'name' => ['The name field is required.'],
    ]));

    $html = view('student_mgmt.components.alerts', [
        'errors' => $errors,
    ])->render();

    expect($html)
        ->toContain('Please fix the following errors:')
        ->toContain('The name field is required.');
});
