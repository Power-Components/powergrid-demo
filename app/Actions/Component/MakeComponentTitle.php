<?php

namespace App\Actions\Component;

final class MakeComponentTitle
{
    public static function handle(string $nameCandidate): string
    {
        return str($nameCandidate)->kebab()
            ->lower()
            ->replace('-table', '')
            ->replace('-', ' ')
            ->title()
            ->toString();
    }
}
