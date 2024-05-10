<?php

namespace App\Actions\Component;

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
