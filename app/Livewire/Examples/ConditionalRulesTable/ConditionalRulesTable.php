<?php

namespace App\Livewire\Examples\ConditionalRulesTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class ConditionalRulesTable extends PowerGridComponent
{
    public string $tableName = 'conditional-rules-table';

    public function setUp(): array
    {
        $this->showCheckBox();

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
        return Dish::with('category');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('in_stock')
            ->add('category_id', fn ($dish) => intval($dish->category_id))
            ->add('category_name', fn ($dish) => e($dish->category->name))
            ->add('price_in_eur', fn ($dish) => Number::currency($dish->price, in: 'EUR', locale: 'pt_PT'))
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [

            Column::make('Row Index', 'id')->index(),

            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->editOnClick(true)
                ->bodyAttribute('!text-wrap') // <--- Must add "!" to override style
                ->searchable()
                ->sortable(),

            Column::make('Category', 'category_name'),

            Column::make('Price', 'price_in_eur', 'price')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('In Stock')
                ->field('in_stock')
                ->toggleable(hasPermission: true, trueLabel: 'yes', falseLabel: 'no')
                ->sortable(),

            Column::make('Created At', 'created_at_formatted'),

            Column::action('Action'),
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('edit')
                ->slot('edit')
                ->class('bg-blue-500 text-white font-bold py-2 px-2 rounded')
                ->dispatch('clickToEdit', ['dishId' => $row->id, 'dishName' => $row->name]),

            Button::add('delete')
                ->slot('delete')
                ->class('bg-red-500 text-white font-bold py-2 px-2 rounded')
                ->dispatch('clickToDelete', ['dishId' => $row->id, 'dishName' => $row->name]),
        ];
    }

    public function actionRules($row): array
    {
        return [
            Rule::checkbox()
                ->when(fn ($dish) => $dish->in_stock == false)
                ->hide(),
            //
            //            Rule::rows()
            //                ->when(fn ($dish) => $dish->in_stock == false)
            //                ->hideToggleable(),

            Rule::button('delete')
                ->when(fn ($dish) => $dish->id == 6)
                ->hide(),
            //
            //            Rule::rows()
            //                ->loop(fn ($loop) => $loop->index % 2)
            //                ->setAttribute('class', '!text-red-500'),
            //
            //            Rule::button('edit')
            //                ->when(fn ($dish) => $dish->id == 5)
            //                ->bladeComponent('livewire-powergrid::icons.arrow', [
            //                    'dish-id' => 'id',
            //                    'class'   => 'w-5 h-5 !text-red-500',
            //                ]),
        ];
    }

    #[On('clickToEdit')]
    public function clickToEdit(int $dishId, string $dishName): void
    {
        $this->js("alert('Editing #{$dishId} -  {$dishName}')");
    }
}
