<?php

namespace App\View\Components\Layout;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Menu extends Component
{
    public Collection $menu;

    public function __construct()
    {
        $this->menu = collect([
            [
                'label' => 'Simple',
                'route' => route('default', ['table' => 'simple']),
                'name' => '/simple',
            ],
            [
                'label' => 'Striped',
                'route' => route('default', ['table' => 'striped']),
                'name' => '/striped',
            ],
            [
                'label' => 'Fixed Header',
                'route' => route('default', ['table' => 'fixed-header']),
                'name' => '/fixed-header',
            ],
            [
                'label' => 'Filters',
                'route' => route('default', ['table' => 'filters']),
                'name' => '/filters',
            ],
            [
                'label' => 'Filters outside',
                'route' => route('default', [
                    'table' => 'filters-outside',
                ]),
                'name' => '/filters-outside',
            ],
            [
                'label' => 'Dynamic Filters',
                'route' => route('default', ['table' => 'dynamic-filters']),
                'name' => '/dynamic-filters',
            ],
            [
                'label' => 'Validation',
                'route' => route('default', ['table' => 'validation']),
                'name' => '/validation',
            ],
            [
                'label' => 'Collection',
                'route' => route('default', ['table' => 'collection']),
                'name' => '/collection',
            ],
            [
                'label' => 'Query Builder',
                'route' => route('default', ['table' => 'query-builder']),
                'name' => '/query-builder',
            ],
            [
                'label' => 'Join',
                'route' => route('default', ['table' => 'join']),
                'name' => '/join',
            ],
            [
                'label' => 'Dishes',
                'route' => route('default', ['table' => 'dishes']),
                'name' => '/dishes',
            ],
            [
                'label' => 'Responsive',
                'route' => route('default', ['table' => 'responsive']),
                'name' => '/responsive',
            ],
            [
                'label' => 'Persist',
                'route' => route('default', ['table' => 'persist']),
                'name' => '/persist',
            ],
            [
                'label' => 'Detail',
                'route' => route('default', ['table' => 'detail']),
                'name' => '/detail',
            ],
            [
                'label' => 'Export',
                'route' => route('default', ['table' => 'export']),
                'name' => '/export',
            ],
            [
                'label' => 'Batch Export',
                'route' => route('default', ['table' => 'batch-export']),
                'name' => '/batch-export',
            ],
            [
                'label' => 'Custom Layout',
                'route' => route('default', ['table' => 'custom-layout']),
                'name' => '/custom-layout',
            ],
            [
                'label' => 'Bulk Actions',
                'route' => route('default', ['table' => 'bulk-action']),
                'name' => '/bulk-action',
            ],
            [
                'label' => 'Soft Delete',
                'route' => route('default', ['table' => 'soft-delete']),
                'name' => '/soft-delete',
            ],
            [
                'label' => 'Summarize',
                'route' => route('default', ['table' => 'summarize']),
                'name' => '/summarize',
            ],
            [
                'label' => 'Wire Elements Modal',
                'route' => route('default', ['table' => 'wire-elements-modal']),
                'name' => '/wire-elements-modal',
            ],
            [
                'label' => 'Extending Button',
                'route' => route('default', ['table' => 'extend-button']),
                'name' => '/extend-button',
            ],

        ]);
    }

    public function render()
    {
        return view('components.layout.menu');
    }
}
