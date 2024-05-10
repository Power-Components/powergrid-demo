<?php

use App\Actions\Component\ParseComponentTag;
use App\Support\DemoComponent;

it('makes a tag', function () {
    $component = DemoComponent::discover('actions-from-view');

    expect(ParseComponentTag::handle($component))->toBe('examples.actions-from-view-table.actions-from-view-table');
});
