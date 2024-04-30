<?php

use App\Http\Controllers\Api\Index;
use Illuminate\Support\Facades\Route;

Route::match([
    'GET', 'POST',
], '/category', Index::class)->name('category.index');

Route::view('/examples/{component}', 'table')->name('default');

Route::get('/advices/edit', fn () => 'work')->name('advices.edit');

Route::view('/', 'about');

Route::fallback(fn () => redirect('/'));
