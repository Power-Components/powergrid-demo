<?php

namespace App\Actions\Component;

use App\Support\DemoComponent;
use Illuminate\Support\Facades\File;

final class FetchComponentAbout
{
    public static function handle(DemoComponent $component): string
    {
        $path = str($component->path)->beforeLast(DIRECTORY_SEPARATOR)->append(DIRECTORY_SEPARATOR . 'about.md');

        return rescue(
            fn () => str(strval(File::get($path)))->markdown()->safeHTML()->forceTargetBlank()->toString(),
            ''
        );
    }
}
