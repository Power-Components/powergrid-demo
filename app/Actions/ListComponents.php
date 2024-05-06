<?php

namespace App\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

final class ListComponents
{
    public static function handle(): Collection
    {
        return collect(File::allFiles(config('powergrid-demo.path')))
            ->reject(fn ($file) => $file->getExtension() != 'php')
            ->map(fn ($file) => str($file)->afterLast(DIRECTORY_SEPARATOR)->before('.php')->toString())
            ->reject(null);
    }
}
