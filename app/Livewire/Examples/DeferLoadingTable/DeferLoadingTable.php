<?php

namespace App\Livewire\Examples\DeferLoadingTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class DeferLoadingTable extends PowerGridComponent
{
    public bool $deferLoading = true;

    public string $loadingComponent = 'components.my-custom-loading';

    public function setUp(): array
    {
        return [

            Header::make()
                ->withoutLoading()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),

            Column::make('Name', 'name'),

            Column::make('Created At', 'created_at_formatted'),
        ];
    }

    public function hydrate(): void
    {
        sleep(20);  // ⏳ Purposefully slow down the Component loading for demonstration purposes.
    }
}
