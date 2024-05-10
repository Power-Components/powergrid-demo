<?php

namespace App\Actions\Component;

use App\Support\DemoComponent;

final class ParseComponentTag
{
    public static function handle(DemoComponent $component): string
    {
        $componentName = str($component->name)->kebab()->prepend('.');

        return str(config('powergrid-demo.path'))
            ->replace('/', '\\')
            ->lower()
            ->after(strtolower(config('livewire.class_namespace')))
            ->replace('\\', '')
            ->append($componentName . $componentName)
            ->toString();
    }
}
