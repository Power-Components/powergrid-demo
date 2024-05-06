<?php

namespace App\Livewire\Examples\SearchablerawTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class SearchablerawTable extends PowerGridComponent
{
    public string $sortField = 'dishes.id';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Header::make()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::query()->select('dishes.*');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('dish_name', fn ($dish) => e($dish->name))
            ->add('produced_at')
            ->add('produced_at_formatted', fn ($dish) => Carbon::parse($dish->produced_at)->format('d/m/Y'));
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
                ->sortable(),

            Column::add()
                ->title('Production date')
                ->field('produced_at_formatted')
                ->searchableRaw('DATE_FORMAT(dishes.produced_at, "%d/%m/%Y")'),
        ];
    }
}
