<?php

namespace App\Helpers\PowerGridThemes;

use PowerComponents\LivewirePowerGrid\Themes\Components\Table;
use PowerComponents\LivewirePowerGrid\Themes\Tailwind;
use PowerComponents\LivewirePowerGrid\Themes\Theme;

class TailwindHeaderFixed extends Tailwind
{
    public string $name = 'tailwind';

    public function table(): Table
    {
        return Theme::table('min-w-full dark:!bg-primary-800')
            ->div('max-h-[29rem] rounded-t-lg relative border-x border-t border-pg-primary-200 dark:bg-pg-primary-700 dark:border-pg-primary-600')
            ->thead('sticky -top-[0.3px] relative bg-pg-primary-200 dark:bg-gray-900')
            ->thAction('!font-bold')
            ->tdAction('')
            ->tr('')
            ->trFilters('sticky top-[39px] bg-white shadow-sm dark:bg-pg-primary-800')
            ->th('font-extrabold px-2 pr-4 py-3 text-left text-xs text-pg-primary-700 tracking-wider whitespace-nowrap dark:text-pg-primary-300')
            ->tbody('text-pg-primary-800')
            ->trBody('border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-700')
            ->tdBody('px-3 py-2 whitespace-nowrap dark:text-pg-primary-200')
            ->tdBodyEmpty('px-3 py-2 whitespace-nowrap dark:text-pg-primary-200')
            ->trBodyClassTotalColumns('')
            ->tdBodyTotalColumns('px-3 py-2 whitespace-nowrap dark:text-pg-primary-200 text-sm text-pg-primary-600 text-right space-y-2');
    }
}
