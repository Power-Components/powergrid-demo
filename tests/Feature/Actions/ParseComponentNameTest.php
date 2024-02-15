<?php

use App\Actions\ParseComponentName;

it('parses different string formats into a component name')
    ->with('valid_component_candidates')
    ->expect(fn (string $candidate) => ParseComponentName::handle($candidate))
    ->toBe('FooBarTable');
