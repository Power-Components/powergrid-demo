<?php

namespace App\Livewire\Examples\InputButtonTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;

use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class InputButtonTable extends PowerGridComponent
{
    public bool $deferLoading = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage(25)
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
            ->add('category_id', fn ($dish) => intval($dish->category_id))
            ->add('category_name', fn ($dish) => e($dish->category->name))
            ->add('price_in_eur', fn ($dish) => Number::currency($dish->price, in: 'EUR', locale: 'pt_PT'))
            ->add('in_stock', fn ($dish) => $dish->in_stock ? 'Yes' : 'No')
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [

            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->bodyAttribute('!text-wrap') // <--- Must add "!" to override style
                ->searchable()
                ->sortable(),

            Column::make('Category', 'category_name'),

            Column::make('Price', 'price_in_eur', 'price')
                ->searchable()
                ->sortable(),

            Column::make('In Stock', 'in_stock'),

            Column::make('Created At', 'created_at_formatted'),

            Column::action('Action'),
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('view')
                ->icon('default-eye', [
                    'class' => 'text-red-500',
                ])
                ->class('text-slate-500 flex gap-2 hover:text-slate-700 hover:bg-slate-100 shadow font-bold p-1 rounded')
                ->dispatch('clickToEdit', ['dishId' => $row?->id, 'dishName' => $row?->name]),
            Button::add('edit')
                ->icon('default-pencil')
                ->class('text-slate-500 flex gap-2 hover:text-slate-700 hover:bg-slate-100 shadow font-bold p-1 rounded')
                ->dispatch('clickToEdit', ['dishId' => $row?->id, 'dishName' => $row?->name]),
            Button::add('download')
                ->icon('default-download')
                ->class('text-slate-500 flex gap-2 hover:text-slate-700 hover:bg-slate-100 shadow font-bold p-1 rounded')
                ->dispatch('clickToEdit', ['dishId' => $row?->id, 'dishName' => $row?->name]),
            Button::add('link')
                ->icon('default-external-link')
                ->class('text-slate-500 flex gap-2 hover:text-slate-700 hover:bg-slate-100 shadow font-bold p-1 rounded')
                ->dispatch('clickToEdit', ['dishId' => $row?->id, 'dishName' => $row?->name]),
            Button::add('delete')
                ->icon('default-trash')
                ->class('text-slate-500 flex gap-2 hover:text-slate-700 hover:bg-slate-100 shadow font-bold p-1 rounded')
                ->dispatch('clickToEdit', ['dishId' => $row?->id, 'dishName' => $row?->name]),
        ];
    }

    #[On('clickToEdit')]
    public function clickToEdit(int $dishId, string $dishName): void
    {
        $this->js("alert('Editing #{$dishId} -  {$dishName}')");
    }
}
