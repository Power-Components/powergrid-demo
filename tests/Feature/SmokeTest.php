<?php

use App\Actions\ListComponents;

use function Pest\Laravel\{get};

it('opens the about page')
    ->get('/')
    ->assertOk()
    ->assertSee('Welcome');

test('All components are accessible', function () {
    ListComponents::handle()->map(fn ($component) => str($component)->before('Table')->kebab()->toString())
        ->each(fn ($route) => get(route('default', ['component' => $route]))->assertOk());
});

it('redirects old example links', function () {
    collect(config('redirect.old_links', []))
        ->each(fn ($route) => get($route)->AssertOk()->assertSeeText('Source Code'));
});
