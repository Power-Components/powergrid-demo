<?php

use Illuminate\Support\Facades\Route;

Route::view('/examples/{component}', 'table')->name('default');

Route::get('/advices/edit', fn () => 'work')->name('advices.edit');

Route::view('/', 'about');

Route::fallback(fn () => redirect('/'));
