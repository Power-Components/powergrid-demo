<?php

use App\Models\Dish;

test('Database has dishes', function () {
    $dishes = Dish::all();

    expect($dishes->count())->toBeGreaterThan(0);
});

test('Home page contains Dishes table', function () {
    $this->get('/')
        ->assertOK()
        ->assertSeeLivewire('dishes-table');
});