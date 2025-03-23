<?php

namespace App\Livewire\Examples\DetailTable;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class DetailTable extends PowerGridComponent
{
    public string $tableName = 'detail-table';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),

            PowerGrid::detail()
                ->view('components.detail')
                ->showCollapseIcon()
                ->params(['name' => 'Luan']),
        ];
    }

    public function datasource(): ?Builder
    {
        return User::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('email')
            ->add('created_at')
            ->add('created_at_formatted', fn ($user) => Carbon::parse($user->created_at)->format('d/m/Y H:i:s'));
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

            Column::make('Created At', 'created_at_formatted', 'created_at')
                ->searchable()
                ->sortable(),

            Column::action('Action'),
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('detail')
                ->slot('Detail')
                ->class('btn btn-primary btn-sm')
                ->toggleDetail($row->id),
        ];
    }

    public function actionRules(): array
    {
        return [
            Rule::rows()
                ->when(fn ($user) => $user->id == 1)
                ->detailView('components.detail-rules', ['test' => 1]),
        ];
    }
}
