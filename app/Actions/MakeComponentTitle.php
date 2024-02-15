<?php

declare(strict_types=1);

namespace App\Actions;

final class MakeComponentTitle
{
    public static function handle(string $componentName): string
    {
        $componentName = ParseComponentName::handle($componentName);

        return str($componentName)->kebab()
            ->lower()
            ->replace('-table', '')
            ->replace('-', ' ')
            ->title()
            ->toString();
    }
}
