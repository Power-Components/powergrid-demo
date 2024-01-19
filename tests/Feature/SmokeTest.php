<?php

use App\Actions\ListComponents;

use function Pest\Laravel\{get};

test('All components are accessible', function () {

    ListComponents::handle()->map(fn ($component) => str($component)->before('Table')->kebab()->toString())
        ->each(fn ($route) => get(route('default', ['component' => $route]))->assertOk());
});
