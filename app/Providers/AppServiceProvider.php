<?php

namespace App\Providers;

use App\Support\ExampleComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Stringable;
use Illuminate\View\ComponentAttributeBag;
use PowerComponents\LivewirePowerGrid\Button;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Route::bind('component', function ($componentName) {

            try {
                return ExampleComponent::discover($componentName);
            } catch (\Exception) {
                abort(404, 'Example not available.');
            }
        });

        if (! Stringable::hasMacro('forceTargetBlank')) {
            Stringable::macro(
                'forceTargetBlank',
                fn (): Stringable => str($this->value)->replace('target="_blank"', '')->replaceMatches('/<(a.*?href=\"[http])([^>]+)>/is', '<\\1\\2 target="_blank">')
            );

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
