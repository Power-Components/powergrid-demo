<?php

namespace App\Actions\Component;

use App\Support\DemoComponent;
use Illuminate\Support\Arr;

final class ParseComponentPath
{
    public static function handle(DemoComponent $component): string
    {
        return Arr::join([
            config('powergrid-demo.path'),
            $component->name,
            $component->name,
        ], DIRECTORY_SEPARATOR) . '.php';
    }
}
