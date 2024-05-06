<?php

namespace App\Livewire\Examples\DatasourceCollectionTable;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class DatasourceCollectionTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            Header::make()
                ->showToggleColumns()
                ->showSearchInput(),

            Footer::make()
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
            ->add('chef_name')
            ->add('balance', fn ($item) => Number::currency($item->balance, in: 'BRL', locale: 'pt-BR'))
            ->add('is_online', fn ($item) => $item->is_online ? '✅' : '❌')
            ->add('created_at', fn ($item) => Carbon::parse($item->created_at))
            ->add('created_at_formatted', fn ($item) => Carbon::parse($item->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Index', 'id')->index(),

            Column::make('ID', 'id'),

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
                ->title('Online')
                ->field('is_online'),

            Column::add()
                ->title('Created At')
                ->field('created_at_formatted'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name'),

            Filter::number('balance')
                ->thousands('.')
                ->decimal(',')
                ->placeholder('lowest', 'highest'),

            Filter::boolean('is_online')
                ->label('✅', '❌'),
        ];
    }
}
