<?php

$searchField = '[wire\:model\.live\.debounce\.700ms="search"]';

it('can filter by existing record')
    ->visit('/examples/actions-from-view')
    ->assertSee('Arkansas Possum Pie')
    ->fill($searchField, 'Bacalhau')
    ->assertDontSee('Arkansas Possum Pie')
    ->assertSee('Bacalhau com natas');

it('returns no results with unexistent value')
    ->visit('/examples/actions-from-view')
    ->assertSee('Arkansas Possum Pie')
    ->assertSee('Bacalhau com natas')
    ->fill($searchField, 'this-dish-does-not-exist')
    ->assertDontSee('Arkansas Possum Pie')
    ->assertDontSee('Bacalhau com natas');
