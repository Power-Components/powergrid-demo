<?php

namespace App\Providers;

use App\Actions\ForceAllLinksTargetBlank;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Stringable;
use Illuminate\View\ComponentAttributeBag;
use PowerComponents\LivewirePowerGrid\Button;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        if (! Stringable::hasMacro('forceTargetBlank')) {
            Stringable::macro('forceTargetBlank', fn (): Stringable => new Stringable(ForceAllLinksTargetBlank::handle(strval($this->value))));
        }

        if (! Stringable::hasMacro('safeHTML')) {
            Stringable::macro('safeHTML', fn (): Stringable => new Stringable(clean(strval($this->value))));
        }

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
