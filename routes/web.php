<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('simple'))->name('default');
Route::get('/simple', fn () => view('simple'))->name('simple');
Route::get('/striped', fn () => view('striped'))->name('striped');
Route::get('/header-fixed', fn () => view('header-fixed'))->name('header-fixed');
Route::get('/collection', fn () => view('collection'))->name('collection');
Route::get('/query-builder', fn () => view('query-builder'))->name('query-builder');
Route::get('/join', fn () => view('join'))->name('join');
Route::get('/multiple', fn () => view('multiple'))->name('multiple');
Route::get('/filters', fn () => view('filters'))->name('filters');
Route::get('/dynamic-filters', fn () => view('dynamic-filters'))->name('dynamic-filters');
Route::get('/filters-outside', fn () => view('filters-outside'))->name('filters-outside');
Route::get('/dish', fn () => view('dish'))->name('dish');
Route::get('/dish-responsive', fn () => view('dish', ['responsive' => true]))->name('dish-responsive');
Route::get('/validation', fn () => view('validation'))->name('validation');
Route::get('/persist', fn () => view('persist'))->name('persist');
Route::get('/detail', fn () => view('detail'))->name('detail');
Route::get('/export', fn () => view('export'))->name('export');
Route::get('/batch', fn () => view('batch'))->name('batch');
Route::get('/custom-layout', fn () => view('custom-layout'))->name('custom-layout');
Route::get('/bulk-actions', fn () => view('bulk-actions'))->name('bulk-actions');
Route::get('/soft-delete', fn () => view('soft-delete'))->name('soft-delete');
Route::get('/wire-elements-modal', fn () => view('wire-elements-modal'))->name('wire-elements-modal');

Route::view('/powergrid', 'powergrid-demo');
