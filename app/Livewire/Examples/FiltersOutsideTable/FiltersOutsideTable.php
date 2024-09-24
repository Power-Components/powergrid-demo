<?php

namespace App\Livewire\Examples\FiltersOutsideTable;

use App\Livewire\Examples\FiltersInlineTable\FiltersInlineTable;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;

final class FiltersOutsideTable extends FiltersInlineTable
{
    public string $tableName = 'filters-outside-table';

    public bool $showFilters = true;

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showToggleColumns()
                ->withoutLoading()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Dish::query()
            ->when(
                $this->categoryId,
                fn ($builder) => $builder->whereHas(
                    'category',
                    fn ($builder) => $builder->where('category_id', $this->categoryId)
                )
                    ->with(['category', 'kitchen'])
            );
    }
}
