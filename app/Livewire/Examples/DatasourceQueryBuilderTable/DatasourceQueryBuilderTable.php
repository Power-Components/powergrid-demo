<?php

namespace App\Livewire\Examples\DatasourceQueryBuilderTable;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class DatasourceQueryBuilderTable extends PowerGridComponent
{
    public string $tableName = 'datasource-query-build-table';

    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::exportable('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            PowerGrid::header()->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return DB::table('users');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('created_at')
            ->add('created_at_formatted', fn ($model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('email')
            ->add('id')
            ->add('name');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

        ];
    }

    public function filters(): array
    {
        return [
            Filter::boolean('active'),

            Filter::datetimepicker('created_at'),

            Filter::inputText('email')->operators(['contains']),

            Filter::inputText('name')->operators(['contains']),
        ];
    }
}
