<?php

namespace App\Livewire;

use App\Models\Dish;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class RadioButtonTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
       // $this->showCheckBox();

        $this->showRadioButton();

        $this->selectedRow = 1;

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return User::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')

           /** Example of custom column using a closure **/
            ->addColumn('name_lower', fn (User $model) => strtolower(e($model->name)))

            ->addColumn('email')
            ->addColumn('created_at_formatted', fn (User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),
//
//            Column::make('Email', 'email')
//                ->sortable()
//                ->searchable(),
//
//            Column::make('Created at', 'created_at_formatted', 'created_at')
//                ->sortable(),

            Column::action('Action')
        ];
    }

    public function actions(\App\Models\User $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    public function actionRules($row): array
    {
       return [
            Rule::rows()
                ->when(fn($row) => $row->id == $this->selectedRow)
                ->setAttribute('class', '!border-2 !border-fuchsia-500 bg-fuchsia-100 hover:!bg-fuchsia-100 dark:bg-fuchsia-800 dark:hover:bg-fuchsia-800'),

           Rule::rows()
               ->setAttribute('wire:click', '$set(\'selectedRow\', '.$row->id.')'),

           Rule::rows()
               ->setAttribute('class', '!cursor-pointer')
       ];
    }
//
//    public function actions($row): array
//    {
//        return [
//            Button::add('edit')
//                ->slot('Edit: ' . $row->id)
//                ->class('text-center'),
//        ];
//    }
//
//    public function actionRules($row): array
//    {
//        return [
//            Rule::button('edit')
//                ->when(fn ($dish) => $dish->id == 1)
//                ->setAttribute('class', 'bg-pg-primary-200')
//                ->setAttribute('title', 'Title changed by setAttributes when id 2')
//                ->setAttribute('wire:click', ['test', ['param1' => $row->id, 'dishId' => $row->id]]),
//        ];
//    }
}
