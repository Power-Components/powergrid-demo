<?php

namespace App\Http\Livewire\PowerGridThemes;

use PowerComponents\LivewirePowerGrid\Themes\Components\Table;
use PowerComponents\LivewirePowerGrid\Themes\Theme;

class Tailwind extends \PowerComponents\LivewirePowerGrid\Themes\Tailwind
{
    public function table(): Table
    {
        return Theme::table('rounded-lg min-w-full divide-y divide-gray-300 border-b dark:bg-gray-600 border-gray-400 ')
            ->thead('bg-gray-50 dark:bg-gray-700')
            ->tr('border border-gray-200 dark:border-gray-400')
            ->th('px-2 pr-4 py-3 text-left text-xs font-medium text-gray-500 tracking-wider whitespace-nowrap dark:text-gray-300')
            ->tbody('text-gray-800')
            ->trBody('border odd:bg-gray-100 hover:odd:bg-gray-200 border-gray-200 dark:border-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700')
            ->tdBody('px-3 py-2 whitespace-nowrap dark:text-gray-200')
            ->tdBodyTotalColumns('px-3 py-2 whitespace-nowrap dark:text-gray-200 text-sm text-gray-600 text-right space-y-2');
    }
}
