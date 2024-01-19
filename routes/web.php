<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'about')->name('about');

Route::redirect('/examples', '/');

Route::view('/examples/{component}', 'table')->name('default');

Route::get('/advices/edit', fn() => 'work')->name('advices.edit');
