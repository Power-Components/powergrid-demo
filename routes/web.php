<?php

use App\Http\Controllers\Api\Index;
use Illuminate\Support\Facades\Route;

Route::view('/examples/{component}', 'table')->name('default');

Route::view('/', 'about');


Route::get('/advices/edit', fn () => 'work')->name('advices.edit');

Route::match([
    'GET', 'POST',
], '/category', Index::class)->name('category.index');

Route::fallback(fn () => redirect('/'));
