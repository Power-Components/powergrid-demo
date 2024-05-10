<?php

namespace App\Actions\Component;

use App\Support\DemoComponent;
use Illuminate\Support\Facades\File;

final class FetchComponentCode
{
    public static function handle(DemoComponent $component): string
    {
        $content = rescue(
            fn () => File::get($component->path),
            ''
        );

        return str($content)
            ->replaceMatches('#/\*.+?\*/#s', '') //Remove docblock
            ->toString();
    }
}
