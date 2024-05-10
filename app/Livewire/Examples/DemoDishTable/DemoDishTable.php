<?php

namespace App\Livewire\Examples\DemoDishTable;

use App\Enums\Diet;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Number;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class DemoDishTable extends PowerGridComponent
{
    public bool $filtersOutside = false;

    public string $sortField = 'dishes.id';

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

    public function header(): array
    {
        return [
            Button::add('bulk-delete')
                ->slot('Bulk delete')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('bulkDelete', []),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::query()
            ->join('categories as newCategories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'newCategories.id');
            })
            ->select('dishes.*', 'newCategories.name as category_name')
            ->toBase();
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
        $options = $this->categorySelectOptions();

        return PowerGrid::fields()
            ->add('id')
            ->add('serving_at')
            ->add('chef_name')
            ->add('dish_name', fn ($dish) => $dish->name)
            ->add('calories', fn ($dish) => $dish->calories . ' kcal')
            ->add('preview', fn ($dish) => '<div class="w-12 h-12"><img class="h-full w-full shrink-0 grow-0 rounded-full" src="' . asset('images/dishes/' . e($dish->image)) . '"></div>')
            ->add('category_id')
            ->add('category_name')
            ->add('price')
            ->add('price_in_eur', fn ($dish) => Number::currency($dish->price, in: 'EUR', locale: 'pt_PT'))
            ->add('in_stock')
            ->add('in_stock_label', fn ($dish) => $dish->in_stock ? 'Yes' : 'No')
            ->add('diet', fn ($dish) => Diet::from($dish->diet)->labels())
            ->add('produced_at')
            ->add('produced_at_formatted', fn ($dish) => Carbon::parse($dish->produced_at)->format('d/m/Y'))
            ->add('category_name', fn ($dish) => Blade::render('<x-select-category type="occurrence" :options=$options  :dishId=$dishId  :selected=$selected/>', ['options' => $options, 'dishId' => intval($dish->id), 'selected' => intval($dish->category_id)]));
    }

    public function columns(): array
    {
        return [

            Column::add()
                ->title('ID')
                ->field('id', 'dishes.id')
                ->searchable()
                ->sortable(),

            Column::make('', 'preview'),

            Column::add()
                ->title('Dish')
                ->field('dish_name', 'dishes.name')
                ->searchable()
                ->contentClasses('!whitespace-normal')
                ->placeholder('placeholder')
                ->sortable(),

            Column::add()
                ->field('diet', 'dishes.diet')
                ->title('Diet'),

            Column::add()
                ->title('Category')
                ->field('category_name', 'categories.name')
                ->placeholder('Category placeholder'),

            Column::make('Price', 'price_in_eur', 'price')
                ->editOnClick(hasPermission: true, dataField: 'price_in_eur'),

            Column::add()
                ->title('Calories')
                ->field('calories')
                ->sortable(),

            Column::add()
                ->title('In Stock')
                ->field('in_stock')
                ->toggleable(hasPermission: true, trueLabel: 'yes', falseLabel: 'no')
                ->sortable(),

            Column::add()
                ->title('Production date')
                ->field('produced_at_formatted'),

            Column::action('Action')
                ->fixedOnResponsive(),
        ];
    }

    public function actions($dish): array
    {
        return [
            Button::add('edit-stock')
                ->slot('edit')
                ->class('bg-blue-500 text-white font-bold py-2 px-2 rounded')
                ->openModal('edit-stock', ['dishId' => $dish->id]),
        ];
    }

    public function actionRules(): array
    {
        return [

            Rule::button('edit')
                ->when(fn ($dish) => $dish->id == 2)
                ->setAttribute('class', 'bg-green-200')
                ->setAttribute('wire:click', ['test', ['param1' => 1, 'dishId' => 'id']]),

            Rule::button('destroy')
                ->when(fn ($dish) => $dish->id == 1)
                ->slot('Delete #1'),

            Rule::checkbox()
                ->when(fn ($dish) => $dish->id == 2)
                ->hide(),

            Rule::rows()
                ->when(fn ($dish) => $dish->in_stock == false)
                ->setAttribute('class', 'bg-yellow-50 hover:bg-yellow-100'),
        ];
    }

    public function onUpdatedToggleable($id, $field, $value): void
    {
        Dish::query()->where('id', $id)->update([
            $field => $value,
        ]);

        $this->skipRender();
    }

    #[On('openModal')]
    public function openModal(string $component, array $arguments)
    {
        dd(get_defined_vars());
    }

    #[On('bulkDelete')]
    public function bulkDelete(): void
    {
        dd([
            'dishIds'                 => $this->checkboxValues,
            'confirmationTitle'       => 'Delete dish',
            'confirmationDescription' => 'Are you sure you want to delete this dish?',
        ]);
    }

    public function categorySelectOptions(): Collection
    {
        return Category::all(['id', 'name'])->mapWithKeys(function ($item) {
            return [
                $item->id => match (strtolower($item->name)) {
                    'meat'    => '🍖 ',
                    'fish'    => '🐟 ',
                    'pie'     => '🍰 ',
                    'garnish' => '🥗 ',
                    'pasta'   => '🍝 ',
                    'dessert' => '🍧 ',
                    'soup'    => '🍲 ',
                } . $item->name,
            ];
        });
    }
}
