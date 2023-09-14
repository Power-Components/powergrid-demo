<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\ComponentAttributeBag;
use PowerComponents\LivewirePowerGrid\Button;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Button::macro('icon', function (string $icon, array $attributes = []) {
            $this->dynamicProperties['icon'] = [
                'component' => 'a',
            ];

            $attributes = new ComponentAttributeBag($attributes);
            $attributes = $attributes->merge(['class' => 'w-5 h-5'])->toHtml();

            $this->slot = Blade::render(<<<HTML
<x-icon name="$icon" $attributes />
HTML, ['attributes' => $attributes]);

            return $this;
        });
    }
}
