<?php

namespace App\Livewire;

use App\Enums\Diet;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class EnumTable extends PowerGridComponent
{
    public bool $filtersOutside = false;

    public string $sortField = 'dishes.id';

    public bool $ableToLoad = false;

    public string $loadingComponent = 'components.my-custom-loading';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Header::make()
                ->showToggleColumns()
                ->showSearchInput(),

            Footer::make()
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
            ->add('serving_at')
            ->add('chef_name')
            ->add('dish_name', fn ($dish) => $dish->name)
            ->add('calories', fn ($dish) => $dish->calories.' kcal')
            ->add('category_id')
            ->add('category_name')
            ->add('price')
            ->add('in_stock')
            ->add('in_stock_label', fn ($dish) => $dish->in_stock ? 'sim' : 'não')
            ->add('diet', fn ($dish) => \App\Enums\Diet::from($dish->diet)->labels())
            ->add('cooking_method', function (Dish $dish) {
                return 'a';

                return $dish->cooking_method->name;
            })
            ->add('nutri_score', function (Dish $dish) {
                return 'b';

                return $dish->nutri_score->name;
            })
            ->add('produced_at')
            ->add('produced_at_formatted', fn ($dish) => Carbon::parse($dish->produced_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title(__('ID'))
                ->field('id', 'dishes.id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title(__('Dish'))
                ->field('dish_name', 'dishes.name')
                ->searchable()
                ->contentClasses('!whitespace-normal')
                ->placeholder('placeholder')
                ->sortable(),

            Column::add()
                ->field('diet', 'dishes.diet')
                ->title(__('Diet')),

            Column::add()
                ->field('cooking_method', 'dishes.cooking_method')
                ->title(__('Cooking Method')),

            Column::add()
                ->field('nutri_score', 'dishes.nutri_score')
                ->title(__('Nutri-score')),
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
