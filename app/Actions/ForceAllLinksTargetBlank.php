<?php

declare(strict_types=1);

namespace App\Actions;

final class ForceAllLinksTargetBlank
{
    public static function handle(string $html): string
    {
        return str($html)->replace('target="_blank"', '')
            ->replaceMatches('/<(a.*?href=\"[http])([^>]+)>/is', '<\\1\\2 target="_blank">')
            ->toString();
    }
}
