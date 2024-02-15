<?php

use App\Actions\GenerateComponentLink;

it('generates the component link')
    ->with('valid_component_candidates')
    ->expect(fn (string $candidate) => GenerateComponentLink::handle($candidate))
    ->toBe('https://github.com/Power-Components/powergrid-demo/blob/powergrid_v5/app/Livewire/FooBarTable.php');
