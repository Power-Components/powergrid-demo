<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class ValidationTable extends PowerGridComponent
{
    public array $name;

    public bool $showErrorBag = true;

    public string $tableName = 'validationTable';

    protected array $rules = [
        'name.*' => ['required', 'min:2', 'max:10'],
    ];

    public function setUp(): array
    {
        return [
            Header::make()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        $this->validate();
    }

    public function onUpdatedToggleable(string|int $id, string $field, string $value): void
    {
        $this->skipRender();
    }

    public function datasource(): ?Builder
    {
        return User::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('active')
            ->add('name')
            ->add('email');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),

            Column::make('NAME', 'name')
                ->sortable()
                ->editOnClick(true)
                ->searchable(),

            Column::make('EMAIL', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Active', 'active')
                ->toggleable(),
        ];
    }
}
