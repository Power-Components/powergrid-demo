<?php

namespace App\Helpers\PowerGridThemes;

use PowerComponents\LivewirePowerGrid\Themes\Components\Table;
use PowerComponents\LivewirePowerGrid\Themes\Theme;

class TailwindHeaderFixed extends \PowerComponents\LivewirePowerGrid\Themes\Tailwind
{
    public function table(): Table
    {
        return Theme::table('rounded-lg min-w-full border border-pg-primary-200 dark:bg-pg-primary-600 dark:border-pg-primary-700')
            ->div('my-3 overflow-x-auto bg-white shadow-lg rounded-lg overflow-y-auto relative transition-height ease-out duration-300 max-h-[29rem]')
            ->thead('sticky shadow-sm -top-[0.9px] shadow-sm bg-pg-primary-100 dark:bg-pg-primary-800 border border-pg-primary-200 dark:border-pg-primary-700')
            ->thAction('!font-bold')
            ->tdAction('')
            ->tr('')
            ->trFilters('bg-white sticky shadow-sm top-[39px] dark:bg-pg-primary-800')
            ->th('font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-pg-primary-700 tracking-wider whitespace-nowrap dark:text-pg-primary-300')
            ->tbody('text-pg-primary-800')
            ->trBody('border border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:odd:bg-pg-primary-700 dark:odd:hover:bg-pg-primary-700 dark:hover:bg-pg-primary-700')
            ->tdBody('pl-[19px] px-3 py-2 whitespace-nowrap dark:text-pg-primary-200')
            ->tdBodyEmpty('px-3 py-2 whitespace-nowrap dark:text-pg-primary-200')
            ->tdBodyTotalColumns('px-3 py-2 whitespace-nowrap dark:text-pg-primary-200 text-sm text-pg-primary-600 text-right space-y-2');
    }
}
