<?php

use App\Http\Controllers\Api\DeployWebhookController;
use App\Http\Controllers\Api\IndexController;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:2,1')->group(function () {
    Route::post(config()->string('app.deploy.route'), DeployWebhookController::class)
        ->withoutMiddleware([PreventRequestForgery::class])
        ->name('deploy');
});

Route::view('/examples/{component}', 'table')->name('default');

Route::view('/', 'about');

Route::get('/advices/edit', fn () => 'work')->name('advices.edit');

Route::match([
    'GET', 'POST',
], '/category', IndexController::class)->name('category.index');

Route::fallback(fn () => redirect('/'));
