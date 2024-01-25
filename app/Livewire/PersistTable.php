<?php

namespace App\Livewire;

use App\Enums\Diet;
use App\Models\Category;
use App\Models\Chef;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;

final class PersistTable extends DishesTable
{
    public function setUp(): array
    {
        $this->persist(['columns', 'filters']);

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            Header::make()
                ->showToggleColumns()
                ->withoutLoading()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function header(): array
    {
        return [];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('dish_name', 'dishes.name'),

            Filter::inputText('name')
                ->placeholder('Test')
                ->operators(['contains']),

            Filter::boolean('in_stock', 'in_stock')
                ->label('In stock', 'Out of stock'),

            Filter::enumSelect('diet', 'dishes.diet')
                ->dataSource(Diet::cases())
                ->optionLabel('dishes.diet'),

            Filter::select('category_name', 'category_id')
                ->dataSource(Category::all())
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::select('chef_name', 'chef_id')
                ->depends(['category_id'])
                ->dataSource(fn ($depends) => Chef::query()
                    ->when(isset($depends['category_id']),
                        fn (Builder $query) => $query->whereRelation('categories',
                            fn (Builder $builder) => $builder->where('id', $depends['category_id'])
                        )
                    )
                    ->get()
                )
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::number('price_BRL', 'price'),

            Filter::datetimepicker('created_at_formatted', 'created_at')
                ->params([
                    'timezone' => 'America/Sao_Paulo',
                ]),
        ];
    }
}
