<?php

use Stevebauman\Purify\Facades\Purify;

if (! function_exists('clear')) {
    function clear(string $input): string
    {
        return Purify::clean($input);
    }
}

if (! function_exists('path_to_namespace')) {
    /**
     * Converts a file path into a namespace
     * "/home/project/App/Livewire/" => "App\Livewire\"
     */
    function path_to_namespace(string $path): string
    {
        return str($path)
            ->replace(base_path(), '')
            ->replace('/', '\\')
            ->ltrim('\\')
            ->explode('\\')
            ->map(fn ($str) => ucfirst($str))
            ->implode('\\');
    }
}
