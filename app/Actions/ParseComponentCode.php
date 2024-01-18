<?php

declare(strict_types=1);

namespace App\Actions;

final class ParseComponentCode
{
    public static function handle(string $code): string
    {
        $removeDocBlock = str()->of($code)
            ->betweenFirst('/**', ' */')
            ->prepend('/**')
            ->append(' */')
            ->toString();

        return str()->of($code)
            ->after('use ')
            ->prepend('<?php'.PHP_EOL.PHP_EOL.'use ')
            ->replace($removeDocBlock, '')
            ->toString();
    }
}
