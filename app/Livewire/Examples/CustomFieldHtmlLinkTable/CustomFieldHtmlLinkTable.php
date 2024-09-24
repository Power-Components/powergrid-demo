<?php

namespace App\Livewire\Examples\CustomFieldHtmlLinkTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;

use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class CustomFieldHtmlLinkTable extends PowerGridComponent
{
    public string $tableName = 'custom-field-html-link-table';

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
        return Dish::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('link', function ($dish) {
                return sprintf(
                    'Click to Search
                    "<a target="_blank"
                    class="underline text-blue-600 hover:text-blue-800 visited:text-purple-600"
                    href="https://www.google.com/search?q=%s">%s</a>"',
                    urlencode(e($dish->name)),
                    e($dish->name)
                );
            })
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),

            Column::make('Name', 'link', 'name'),

            Column::make('Link', 'link', 'link'),

            Column::make('Created At', 'created_at_formatted'),
        ];
    }
}
