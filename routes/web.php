<?php

use App\Http\Controllers\ComponentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'about')->name('about');

Route::get('/examples/{table}', ComponentController::class)->name('default');

Route::get('/advices/edit', fn () => 'work')->name('advices.edit');
