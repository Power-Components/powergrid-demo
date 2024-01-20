<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Facades\File;

final class FetchComponentAbout
{
    public static function handle(string $componentName): string
    {
        $componentName = ParseComponentName::handle($componentName);

        $path = resource_path('/markdown/Components/'.$componentName.'.md');

        try {
            return str(strval(File::get($path)))->markdown()
                ->safeHTML()
                ->forceTargetBlank()
                ->toString();
        } catch (\Exception) {
        }

        return '';
    }
}
