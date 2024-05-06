<?php

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
