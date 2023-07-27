<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use PowerComponents\LivewirePowerGrid\Rules\RuleActions;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class DetailTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        return [
            Header::make()
                ->showToggleColumns()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),

            Detail::make()
                ->view('components.detail')
                ->params(['name' => 'Luan'])
                ->showCollapseIcon(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     */
    public function datasource(): ?Builder
    {
        return User::query();
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('email')
            ->addColumn(
                'created_at_formatted',
                fn (User $model) => Carbon::parse($model->created_at)
                    ->format('d/m/Y H:i:s')
            );
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Created At', 'created_at_formatted', 'created_at')
                ->searchable()
                ->sortable(),
        ];
    }

    public function actions(): array
    {
        return [
            Button::add('detail')
                ->caption('Detail')
                ->class('bg-indigo-500 rounded-md cursor-pointer text-white px-3 py-2 m-1 text-sm')
                ->toggleDetail(),
        ];
    }

    /**
     * PowerGrid Dish Action Rules.
     *
     * @return array<int, RuleActions>
     */
    public function actionRules(): array
    {
        return [
            Rule::rows()
                ->when(fn (User $user) => $user->id == 1)
                ->detailView('components.detail-rules', ['test' => 1]),
        ];
    }
}
