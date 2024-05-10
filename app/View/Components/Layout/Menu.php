<?php

namespace App\View\Components\Layout;

use App\Actions\Component\MakeComponentTitle;
use App\Actions\ListComponents;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Menu extends Component
{
    public Collection $menu;

    public function __construct(Request $request)
    {
        $this->menu = collect(config('powergrid-demo-menu.items', []))
            ->merge($this->getComponents())
            ->map(function ($item) {
                $item['target'] = isset($item['target']) && ! empty($item['target']) ? "target=\"{$item['target']}\"" : null;

                return $item;
            });
    }

    public function getComponents(): Collection
    {
        return ListComponents::handle()
            ->map(fn ($component) => str($component)->before('Table')->kebab()->toString())
            ->map(function ($item) {
                return [
                    'label'  => MakeComponentTitle::handle($item),
                    'url'    => route('default', ['component' => $item]),
                    'name'   => '/' . $item,
                    'target' => '',
                ];
            });
    }

    public function render()
    {
        return view('components.layout.menu');
    }
}
