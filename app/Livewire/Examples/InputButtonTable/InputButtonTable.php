<?php

namespace App\Livewire\Examples\InputButtonTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

#[Lazy]
class InputButtonTable extends PowerGridComponent
{
    public string $tableName = 'input-button-table';

    public function setUp(): array
    {
        $this->showCheckBox();

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
            ->add('in_stock', function ($dish) {
                return [
                    $dish->in_stock ? 'check-circle' : 'x-circle' => [
                        'text-color' => $dish->in_stock ? 'text-green-600' : 'text-red-600'
                    ]
                ];
            })
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('M j, Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->bodyAttribute('!text-wrap')
                ->searchable()
                ->sortable(),

            Column::make('Category', 'category_name'),

            Column::make('Price', 'price_in_eur', 'price')
                ->searchable()
                ->sortable(),

            Column::make('In Stock', 'in_stock')
                ->template(),

            Column::make('Created At', 'created_at_formatted'),

            Column::action('Action'),
        ];
    }

    public function rowTemplates(): array
    {
        return [
            'check-circle' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 {{ text-color }}">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>',
            'x-circle' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 {{ text-color }}">
  <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>
'
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('view')
                ->icon('default-eye', [
                    'class' => '!text-green-500',
                ])
                ->slot('View')
                ->class('text-slate-500 flex gap-2 hover:text-slate-700 hover:bg-slate-100 font-bold p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['dishId' => $row?->id, 'dishName' => $row?->name]),
            Button::add('edit')
                ->icon('default-pencil', [
                    'class' => '!text-blue-500',
                ])
                ->slot('Edit')
                ->class('text-slate-500 flex gap-2 hover:text-slate-700 hover:bg-slate-100 font-bold p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['dishId' => $row?->id, 'dishName' => $row?->name]),
            Button::add('download')
                ->icon('default-download', [
                    'class' => '!text-slate-500',
                ])
                ->slot('Download')
                ->class('text-slate-500 flex gap-2 hover:text-slate-700 hover:bg-slate-100 font-bold p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['dishId' => $row?->id, 'dishName' => $row?->name]),
            Button::add('delete')
                ->slot('Delete')
                ->icon('default-trash', [
                    'class' => 'text-red-500',
                ])
                ->class('text-slate-500 flex gap-2 hover:text-slate-700 hover:bg-slate-100 font-bold p-1 px-2 rounded')
                ->dispatch('clickToEdit', ['dishId' => $row?->id, 'dishName' => $row?->name]),
        ];
    }

    #[On('clickToEdit')]
    public function clickToEdit(int $dishId, string $dishName): void
    {
        $this->js("alert('Editing #{$dishId} -  {$dishName}')");
    }
}
