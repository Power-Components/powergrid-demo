<?php

namespace App\Livewire\Examples\InputSelectTable;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Number;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class InputSelectTable extends PowerGridComponent
{
    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
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

    public function fields(): PowerGridFields
    {
        $options = $this->categorySelectOptions();

        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('category_id', fn ($dish) => intval($dish->category_id))
            ->add('price_in_eur', fn ($dish) => Number::currency($dish->price, in: 'EUR', locale: 'pt_PT'))
            ->add('in_stock', fn ($dish) => $dish->in_stock ? 'Yes' : 'No')
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'))
            ->add('category_name', function ($dish) use ($options) {
                if (is_null($dish->category_id)) {
                    dd($dish);
                }

                return Blade::render('<x-select-category type="occurrence" :options=$options  :dishId=$dishId  :selected=$selected/>', ['options' => $options, 'dishId' => intval($dish->id), 'selected' => intval($dish->category_id)]);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),

            Column::make('Dish Name', 'name')
                ->bodyAttribute('!text-wrap')
                ->searchable()
                ->sortable(),

            Column::make('Category', 'category_name'),

            Column::make('Price', 'price_in_eur', 'price'),

            Column::make('In Stock', 'in_stock'),

            Column::make('Created At', 'created_at_formatted'),
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

    #[On('categoryChanged')]
    public function categoryChanged($categoryId, $dishId): void
    {
        dd("category Id: {$categoryId} for Dish id: {$dishId}");
    }
}
