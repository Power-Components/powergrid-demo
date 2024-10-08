<?php

namespace App\Actions;

final class GetMajorVersion
{
    public static function handle(string $version): string
    {
        return str($version)->append('.')
            ->before('.')
            ->toString();
    }
}
