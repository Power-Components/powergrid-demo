<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('table', [
    'title' => 'Simple',
    'component' => 'simple-table',
]))
    ->name('default');

Route::get('/{table}', fn (string $table) => view('table', [
    'title' => str($table)
        ->ucfirst()
        ->title()
        ->replace('-', ' '),
    'component' => $table.'-table',
]))
    ->name('default');
