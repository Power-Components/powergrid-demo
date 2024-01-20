<?php

namespace App\View\Components\Layout;

use App\Actions\ListComponents;
use App\Actions\MakeComponentTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Menu extends Component
{
    public Collection $menu;

    public function __construct(Request $request)
    {
        $components = ListComponents::handle()
            ->map(fn ($component) => str($component)->before('Table')->kebab()->toString())
            ->map(function ($item) {
                return [
                    'label' => MakeComponentTitle::handle($item),
                    'route' => route('default', ['component' => $item]),
                    'name' => '/'.$item,
                ];
            });

        $this->menu = collect(config('menu.items', []))
            ->merge($components);

        if (app()->isProduction() === false) {
            $this->menu = $this->menu->prepend([
                'label' => ' ** Cypress **',
                'route' => route('default', ['component' => 'cypress']),
                'name' => '/cypress',
            ]);
        }
    }

    public function render()
    {
        return view('components.layout.menu');
    }
}
