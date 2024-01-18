<?php

declare(strict_types=1);

namespace App\Actions;

final class ParseComponentName
{
    public static function handle(string $nameCandidate): string
    {
        return str($nameCandidate)
            ->kebab()
            ->lower()
            ->replace('-table', '')
            ->append('Table')
            ->studly()
            ->replaceMatches('/[^A-Za-z0-9]++/', '')->toString();
    }
}
