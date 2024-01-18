<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Facades\File;

final class FetchComponentCode
{
    public static function handle(string $componentName): string
    {
        $componentName = ParseComponentName::handle($componentName);

        $path = app_path('/Livewire/' . $componentName . '.php');
        $content = File::get($path);

        return ParseComponentCode::handle(strval($content));
    }
}
