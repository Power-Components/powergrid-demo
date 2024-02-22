<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

final class GetVersionFromComposerJson
{
    /**
     * @param  string|array<int, string>  $packages
     * @return Collection<int, string>
     */
    public static function handle(string|array $packages): Collection
    {

        $file = json_decode((string) File::get(base_path('composer.lock')));

        if (is_string($packages)) {
            $packages = [$packages];
        }

        return collect($file->packages)
            ->whereIn('name', $packages)
            ->map(fn (object $item): array => ['name' => $item->name,  'description' => $item->description, 'version' => $item->version, 'major_version' => GetMajorVersion::handle($item->version)]);
    }
}
