<?php

namespace App\Actions\Component;

use App\Support\DemoComponent;

/**
 * @credit: Regex by https://polymermallard.medium.com/regex-fix-duplicate-slashes-without-affecting-protocol-daa1ac34a469
 */
final class GenerateComponentLink
{
    public static function handle(DemoComponent $component): string
    {
        return str('')->append(config('powergrid-demo-github.repository_url', ''))
            ->append('//blob//')
            ->append(config('powergrid-demo-github.repository_default_branch', ''))
            ->append('/' . path_to_namespace($component->path))
            ->replace('\\', '/')
            ->replaceMatches('#(?<!:)/+#im', '/')
            ->toString();
    }
}
