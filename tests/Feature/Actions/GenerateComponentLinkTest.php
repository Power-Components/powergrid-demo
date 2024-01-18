<?php

use App\Actions\GenerateComponentLink;

beforeEach(function () {
    app('config')->set('repository_url', 'https://github.com/Power-Components/powergrid-demo-misc/');
    app('config')->set('repository_default_branch', 'main');
});

it('generates the component link')
    ->with('valid_component_candidates')
    ->expect(fn (string $candidate) => GenerateComponentLink::handle($candidate))
    ->toBe('https://github.com/Power-Components/powergrid-demo-misc/blob/main/app/Livewire/FooBarTable.php');
