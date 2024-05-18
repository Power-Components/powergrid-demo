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
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

class DemoDishTable extends PowerGridComponent
{
    use WithExport;

    public bool $filtersOutside = false;

    public string $sortField = 'dishes.id';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->columnWidth([
                    2 => 30,
                ])
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            Header::make()
                ->showToggleColumns()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),

            Detail::make()
                ->view('components.dish-detail')
                ->showCollapseIcon(),
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
            ->add('calories')
            ->add('dish_name', fn ($dish) => $dish->name)
            ->add('calories_formatted', fn ($dish) => $dish->calories . ' kcal')
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
            ->add('category_name', function ($dish) use ($options) {
                return $dish->in_stock == false ? $dish->category_name :
                 Blade::render('<x-select-category type="occurrence" :options=$options  :dishId=$dishId  :selected=$selected/>', ['options' => $options, 'dishId' => intval($dish->id), 'selected' => intval($dish->category_id)]);
            });
    }

    public function columns(): array
    {
        return [

            Column::add()
                ->title('ID')
                ->field('id', 'dishes.id')
                ->searchable()
                ->sortable(),

            Column::make('', 'preview')
                ->visibleInExport(visible: false),

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
                ->visibleInExport(visible: false)

                ->field('category_name', 'categories.name')
                ->placeholder('Category placeholder'),

            Column::make('Price', 'price_in_eur', 'price')
                ->visibleInExport(visible: false)

                ->editOnClick(hasPermission: true, dataField: 'price_in_eur'),

            Column::add()
                ->title('Calories')
                ->field('calories_formatted', 'calories')
                ->visibleInExport(visible: false)
                ->sortable(),

            Column::add()
                ->title('Production date')
                ->field('produced_at_formatted'),

            Column::add()
                ->title('In Stock')
                ->field('in_stock')
                ->toggleable(hasPermission: true, trueLabel: 'yes', falseLabel: 'no')
                ->sortable(),

            Column::action('Action')
                ->fixedOnResponsive(),
        ];
    }

    public function actions($dish): array
    {
        return [
            Button::add('order-now')
                ->slot('order now')
                ->class('bg-blue-500 text-white font-bold py-2 px-2 rounded')
                ->openModal('order-now', ['dishId' => $dish->id]),
        ];
    }

    public function actionRules(): array
    {
        return [
            Rule::button('order-now')
                ->when(fn ($dish) => $dish->in_stock == false)
                ->slot('- not in stock -')
                ->setAttribute('class', '!bg-red-100')
                ->disable(),

            Rule::button('destroy')
                ->when(fn ($dish) => $dish->id == 1)
                ->slot('Delete #1'),

            Rule::checkbox()
                ->when(fn ($dish) => $dish->in_stock == false)
                ->hide(),

            Rule::rows()
                ->when(fn ($dish) => $dish->in_stock == false)
                ->setAttribute('class', 'bg-red-50 hover:bg-red-100'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('dish_name', 'dishes.name')->placeholder('Dish Name'),

            Filter::boolean('in_stock', 'in_stock')
                ->label('In Stock', 'Out of Stock'),

            Filter::number('price_BRL', 'price')
                ->thousands('.')
                ->decimal(',')
                ->placeholder('lowest', 'highest'),

        ];
    }

    public function onUpdatedToggleable($id, $field, $value): void
    {
        Dish::query()->where('id', $id)->update([
            $field => $value,
        ]);
    }

    #[On('categoryChanged')]
    public function categoryChanged($categoryId, $dishId): void
    {
        dd("category Id: {$categoryId} for Dish id: {$dishId}");
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

    public function summarizeFormat(): array
    {
        return [
            'calories.{avg}' => fn ($value) => Number::format($value, locale: 'br', precision: 2) . ' kcal',
        ];
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
