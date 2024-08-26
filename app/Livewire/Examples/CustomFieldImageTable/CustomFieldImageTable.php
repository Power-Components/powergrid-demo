<?php

namespace App\Livewire\Examples\CustomFieldImageTable;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class CustomFieldImageTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        return [
            PowerGrid::exportable('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Collection
    {
        return collect([
            [
                'id'         => 29,
                'name'       => 'Luan',
                'balance'    => 241.86,
                'is_online'  => true,
                'created_at' => '2023-01-01 00:00:00',
            ],
            [
                'id'         => 57,
                'name'       => 'Daniel',
                'balance'    => 166.51,
                'is_online'  => true,
                'created_at' => '2023-02-02 00:00:00',
            ],
            [
                'id'         => 93,
                'name'       => 'Claudio',
                'balance'    => 219.01,
                'is_online'  => false,
                'created_at' => '2023-03-03 00:00:00',
            ],
            [
                'id'         => 104,
                'name'       => 'Vitor',
                'balance'    => 44.28,
                'is_online'  => true,
                'created_at' => '2023-04-04 00:00:00',
            ],
        ]);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('avatar', fn ($item) => '<img class="w-8 h-8 shrink-0 grow-0 rounded-full" src="' . asset("images/avatars/{$item->id}.jpeg") . '">')
            ->add('balance', fn ($item) => Number::currency($item->balance, in: 'BRL', locale: 'pt-BR'))
            ->add('created_at', fn ($item) => Carbon::parse($item->created_at))
            ->add('created_at_formatted', fn ($item) => Carbon::parse($item->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Index', 'id')->index(),

            Column::make('Avatar', 'avatar'),

            Column::add()
                ->title('Name')
                ->field('name')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Balance')
                ->field('balance')
                ->sortable(),

            Column::add()
                ->title('Created At')
                ->field('created_at_formatted'),
        ];
    }
}
