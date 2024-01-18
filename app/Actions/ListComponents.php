<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class ListComponents
{
    public static function handle(): Collection
    {

        return collect(File::files(app_path('Livewire')))
            ->reject(fn ($file) => Str::endsWith($file->getFilename(), 'Table.php') === false)
            ->map(fn ($file) => str($file)->afterLast(DIRECTORY_SEPARATOR)->before('.php')->toString())
            ->reject(null);
    }
}
