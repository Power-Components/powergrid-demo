<?php

namespace App\Livewire;

use App\Actions\GetVersionFromComposerJson;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class InstalledPackages extends PowerGridComponent
{
    public function datasource(): ?Collection
    {
        return GetVersionFromComposerJson::handle(
            [
                'laravel/framework',
                'power-components/livewire-powergrid',
                'openspout/openspout',
            ]
        )
            ->map(fn ($package, $key) => ['id' => $key, ...$package]);
    }

    public function setUp(): array
    {
        return [];

    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('version', fn (object $item): string => $item->name === 'laravel/framework' ? $item->major_version : $item->version);

    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->hidden(),
            Column::make('Name', 'name'),
            Column::make('Version', 'version'),
            Column::make('Description', 'description')
                ->contentClasses('!whitespace-normal')
        ];
    }
}
