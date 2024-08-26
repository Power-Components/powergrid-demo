<?php

namespace App\Helpers\PowerGridThemes;

use PowerComponents\LivewirePowerGrid\Themes\Tailwind;

class TailwindHeaderFixed extends Tailwind
{
    public string $name = 'tailwind';

    public function table(): array
    {
        return [
            'layout' => [
                'base'      => 'p-3 align-middle inline-block min-w-full w-full sm:px-6 lg:px-8',
                'div'       => 'max-h-[29rem] rounded-t-lg relative border-x border-t border-pg-primary-200 dark:bg-pg-primary-700 dark:border-pg-primary-600',
                'table'     => 'min-w-full dark:!bg-primary-800',
                'container' => '-my-2 overflow-x-auto sm:-mx-3 lg:-mx-8',
                'actions'   => 'flex gap-2',
            ],

            'header' => [
                'thead'    => 'sticky -top-[0.3px] relative bg-pg-primary-200 dark:bg-gray-900',
                'tr'       => '',
                'th'       => 'font-extrabold px-3 py-3 text-left text-xs text-pg-primary-700 tracking-wider whitespace-nowrap dark:text-pg-primary-300',
                'thAction' => '!font-bold',
            ],

            'body' => [
                'tbody'              => 'text-pg-primary-800',
                'tbodyEmpty'         => '',
                'tr'                 => 'border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-700',
                'td'                 => 'px-3 py-2 whitespace-nowrap dark:text-pg-primary-200',
                'tdEmpty'            => 'p-2 whitespace-nowrap dark:text-pg-primary-200',
                'tdSummarize'        => 'p-2 whitespace-nowrap dark:text-pg-primary-200 text-sm text-pg-primary-600 text-right space-y-2',
                'trSummarize'        => '',
                'tdFilters'          => '',
                'trFilters'          => 'sticky top-[39px] bg-white shadow-sm dark:bg-pg-primary-800',
                'tdActionsContainer' => 'flex gap-2',
            ],
        ];
    }
}
