<?php

namespace App\Exceptions;

final class DemoComponentException extends \Exception
{
    /**
     * @phpstan-return never
     *
     * @throws \Exception
     */
    public static function FileDoesNotExist(): never
    {
        throw new self('File does not exist.');
    }
}
