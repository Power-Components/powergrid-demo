<?php

namespace App\Livewire\Examples\AutoRefreshTable;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class AutoRefreshTable extends PowerGridComponent
{
    public string $tableName = 'dishTable';

    public function setUp(): array
    {
        return [
            Header::make()
                ->includeViewOnTop('components.header.last-update'),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Collection
    {
        return collect([
            [
                'id'        => 29,
                'name'      => 'Luan',
                'balance'   => 241.86,
                'last_seen' => $this->_fakeLastSeen(),
            ],
            [
                'id'        => 57,
                'name'      => 'Daniel',
                'balance'   => 166.51,
                'last_seen' => $this->_fakeLastSeen(),
            ],
            [
                'id'        => 93,
                'name'      => 'Claudio',
                'balance'   => 219.01,
                'last_seen' => $this->_fakeLastSeen(),
            ],
            [
                'id'        => 104,
                'name'      => 'Vitor',
                'balance'   => 44.28,
                'last_seen' => $this->_fakeLastSeen(),
            ],
        ]);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('last_seen')
            ->add('balance', fn ($item) => Number::currency($item->balance, in: 'BRL', locale: 'pt-BR'));
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
                ->title('Last Seen')
                ->field('last_seen'),
        ];
    }

    // 😎 Populate the table with fake data
    public function _fakeLastSeen(): string
    {
        return Carbon::parse(fake()->dateTimeBetween('-1 hour', '+2 hours'))->diffForHumans();
    }
}
