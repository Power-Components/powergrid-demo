<?php

use App\Actions\GetMajorVersion;

it('can properly get the major version', function (string $version) {
    expect(GetMajorVersion::handle($version))->toBeIn(['10', 'v10']);
})->with([
    'v10.45.1',
    'v10',
    'v10.1',
    'v10',
    '10.45.1',
    '10',
    '10.1',
    '10',
]);
