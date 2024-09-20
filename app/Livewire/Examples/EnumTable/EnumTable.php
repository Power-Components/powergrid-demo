<?php

namespace App\Livewire\Examples\EnumTable;

use App\Enums\Diet;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class EnumTable extends PowerGridComponent
{
    public string $tableName = 'enum-table';

    public bool $filtersOutside = false;

    public string $sortField = 'dishes.id';

    public bool $ableToLoad = false;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showToggleColumns(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::query();
    }

    public function relationSearch(): array
    {
        return [
            'category' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('dish_name', fn ($dish) => $dish->name)
            ->add('diet', fn ($dish) => \App\Enums\Diet::from($dish->diet)->labels());
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id', 'dishes.id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Dish')
                ->field('dish_name', 'dishes.name')
                ->searchable()
                ->contentClasses('!whitespace-normal')
                ->placeholder('placeholder')
                ->sortable(),

            Column::add()
                ->field('diet', 'dishes.diet')
                ->searchable()
                ->title('Diet'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::enumSelect('diet', 'dishes.diet')
                ->dataSource(Diet::cases())
                ->optionLabel('dishes.diet'),
        ];
    }
}
