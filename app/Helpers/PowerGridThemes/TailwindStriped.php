<?php

namespace App\Helpers\PowerGridThemes;

use PowerComponents\LivewirePowerGrid\Themes\Components\Table;
use PowerComponents\LivewirePowerGrid\Themes\Theme;

class TailwindStriped extends \PowerComponents\LivewirePowerGrid\Themes\Tailwind
{
    public function table(): Table
    {
        return Theme::table('rounded-lg min-w-full border border-pg-primary-200 dark:bg-pg-primary-600 dark:border-pg-primary-500')
            ->div('my-3 overflow-x-auto bg-white shadow-lg rounded-lg overflow-y-auto relative')
            ->thead('shadow-sm bg-pg-primary-100 dark:bg-pg-primary-800 border border-pg-primary-200 dark:border-pg-primary-500')
            ->tr('')
            ->trFilters('bg-white shadow-sm dark:bg-pg-primary-700')
            ->th('font-semibold px-2 pr-4 py-3 text-left text-sm font-semebold text-pg-primary-700 tracking-wider whitespace-nowrap dark:text-pg-primary-300')
            ->tbody('text-pg-primary-800')
            ->trBody('even:bg-pg-primary-100 hover:odd:bg-pg-primary-200 border border-pg-primary-200 dark:border-pg-primary-400 hover:bg-pg-primary-50 dark:bg-pg-primary-700 dark:odd:bg-pg-primary-800 dark:odd:hover:bg-pg-primary-900 dark:hover:bg-pg-primary-700')
            ->tdBody('pl-[19px] px-3 py-2 whitespace-nowrap dark:text-pg-primary-200')
            ->tdBodyTotalColumns('px-3 py-2 whitespace-nowrap dark:text-pg-primary-200 text-sm text-pg-primary-600 text-right space-y-2');
    }
}
