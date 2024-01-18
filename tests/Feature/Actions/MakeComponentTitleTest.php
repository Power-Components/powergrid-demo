<?php

use App\Actions\MakeComponentTitle;

it('generates a component title')
    ->with('valid_component_candidates')
    ->expect(fn (string $candidate) => MakeComponentTitle::handle($candidate))
    ->toBe('Foo Bar');
