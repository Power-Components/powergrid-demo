<?php

namespace App\Actions\Component;

use App\Support\DemoComponent;
use Illuminate\Support\Facades\File;

final class FetchComponentConfig
{
    public static function handle(DemoComponent $component): array
    {
        $path = str($component->path)->beforeLast(DIRECTORY_SEPARATOR)->append(DIRECTORY_SEPARATOR . 'config.json');

        return rescue(
            fn () => json_decode(strval(File::get($path)), associative: true),
            []
        );
    }
}
