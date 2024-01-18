<?php

declare(strict_types=1);

namespace App\Actions;

/**
 * @credit: Regex by https://polymermallard.medium.com/regex-fix-duplicate-slashes-without-affecting-protocol-daa1ac34a469
 */
final class GenerateComponentLink
{
    public static function handle(string $componentName): string
    {
        $componentName = ParseComponentName::handle($componentName);

        return str('')->append(config('app.repository_url', ''))
            ->append('//blob//')
            ->append(config('app.repository_default_branch', ''))
            ->append("/app/Livewire/{$componentName}.php")
            ->replaceMatches('#(?<!:)/+#im', '/')
            ->toString();
    }
}
