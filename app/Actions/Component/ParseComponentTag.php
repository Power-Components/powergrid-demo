<?php

namespace App\Actions\Component;

use App\Support\DemoComponent;

final class ParseComponentTag
{
    public static function handle(DemoComponent $component): string
    {
        return str(config('powergrid-demo.path'))
            ->replace('/', '\\')
            ->append('\\' . $component->name)
            ->append('\\' . $component->name)
            ->lower()
            ->after(strtolower(config('livewire.class_namespace')))
            ->ltrim('\\')
            ->replace('\\', '.')
            ->toString();
    }
}
