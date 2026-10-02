<?php

use Illuminate\Support\Facades\File;

test('application has correct timezone and locale configured', function () {
    expect(config('app.timezone'))->toBe('Asia/Jakarta');
    expect(config('app.locale'))->toBe('id');
    expect(config('app.fallback_locale'))->toBe('id');
});

test('storage symlink is properly created in public directory', function () {
    expect(File::exists(public_path('storage')))->toBeTrue();
});

test('artisan verify-setup command completes successfully', function () {
    $this->artisan('app:verify-setup')
        ->assertSuccessful();
});

test('base layout can be rendered without errors', function () {
    $viewRendered = view('layouts.app')->render();
    expect($viewRendered)->toContain('AmaliahSync');
    expect($viewRendered)->toContain('cdn.tailwindcss.com');
});
