<?php

it('properly converts path to namespace', function (string $filePath, string $namespace) {
    expect(path_to_namespace($filePath))->toBe($namespace);
})->with([
    [fn () => app_path('/Livewire/Examples/ActionRulesTable'), 'App\Livewire\Examples\ActionRulesTable'],
    [fn () => base_path('/database/factories'), 'Database\Factories'],
]);
