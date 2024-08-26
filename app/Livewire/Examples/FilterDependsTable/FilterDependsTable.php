<?php

namespace App\Livewire\Examples\FilterDependsTable;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;

use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class FilterDependsTable extends PowerGridComponent
{
    public string $sortField = 'states.id';

    public function setUp(): array
    {
        return [

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return City::query()
            ->join('states', function ($state) {
                $state->on('cities.state_id', '=', 'states.id');
            })
            ->select('states.id as state_id', 'states.name as state_name', 'cities.name as city_name', 'cities.id as city_id');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('city_name')
            ->add('state_name');
    }

    public function columns(): array
    {
        return [

            Column::make('State', 'state_name', 'states.id'),

            Column::make('City', 'city_name', 'cities.name'),

        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('state_name', 'states.id')
                ->dataSource(State::all())
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::select('city_name', 'cities.id')
                ->depends(['state_id'])
                ->dataSource(
                    fn ($depends) => City::query()
                        ->when(
                            isset($depends['state_id']),
                            fn (Builder $query) => $query->whereRelation(
                                'state',
                                fn (Builder $builder) => $builder->where('id', $depends['state_id'])
                            )
                        )
                        ->get()
                )
                ->optionLabel('name')
                ->optionValue('id'),

        ];
    }
}
