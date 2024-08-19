<?php

namespace App\Livewire\Examples\CustomThemeTable;

use App\Helpers\PowerGridThemes\TailwindStriped;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;

use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class CustomThemeTable extends PowerGridComponent
{
    public string $someProperty =  'foobar';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput()
                ->includeViewOnTop('components.header.view-on-top')
                ->includeViewOnBottom('components.header.view-on-bottom'),

            PowerGrid::footer()
                ->showPerPage(4)
                ->showRecordCount()
                ->includeViewOnTop('components.bottom.view-on-top')
                ->includeViewOnBottom('components.bottom.view-on-bottom')
                ->pagination('components.pagination'),
        ];
    }

    public function datasource(): ?Builder
    {
        return User::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('email')
            ->add('created_at_formatted', fn ($user) => Carbon::parse($user->created_at)->format('d/m/Y H:i:s'))
            ->add('updated_at_formatted', fn ($user) => Carbon::parse($user->updated_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id'),

            Column::add()
                ->title('Name')
                ->field('name')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Email')
                ->field('email')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Created At')
                ->field('created_at_formatted', 'created_at')
                ->searchable()
                ->sortable(),

        ];
    }

    public function template(): ?string
    {
        return TailwindStriped::class;
    }
}
