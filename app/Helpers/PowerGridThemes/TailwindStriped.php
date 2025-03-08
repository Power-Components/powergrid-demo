<?php

namespace App\Helpers\PowerGridThemes;

use PowerComponents\LivewirePowerGrid\Themes\Tailwind;

class TailwindStriped extends Tailwind
{
    public function table(): array
    {
        return [
            'layout' => [
                'base'      => 'p-3 align-middle inline-block min-w-full w-full sm:px-6 lg:px-8',
                'div'       => 'rounded-t-lg relative border-x border-t border-pg-primary-200 dark:bg-pg-primary-700 dark:border-pg-primary-600',
                'table'     => 'min-w-full dark:!bg-primary-800',
                'container' => '-my-2 overflow-x-auto sm:-mx-3 lg:-mx-8',
            ],

            'header' => [
                'thead'    => 'shadow-sm rounded-t-lg bg-pg-primary-100 dark:bg-pg-primary-900',
                'tr'       => '',
                'th'       => 'font-extrabold px-3 py-3 text-left text-xs text-pg-primary-700 tracking-wider whitespace-nowrap dark:text-pg-primary-300',
                'thAction' => '!font-bold',
            ],

            'body' => [
                'tbody'       => 'text-pg-primary-800 text-blue- ',
                'tbodyEmpty'  => '',
                'tr'          => 'even:bg-neutral-100 dark:even:bg-pg-primary-700 border-b border-pg-primary-100 dark:border-pg-primary-600 hover:bg-pg-primary-50 dark:bg-pg-primary-800 dark:hover:bg-pg-primary-800',
                'td'          => 'px-3 py-2 whitespace-nowrap dark:text-pg-primary-200',
                'tdEmpty'     => 'p-2 whitespace-nowrap dark:text-pg-primary-200',
                'tdSummarize' => 'p-2 whitespace-nowrap dark:text-pg-primary-200 text-sm text-pg-primary-600 text-right space-y-2',
                'trSummarize' => '',
                'tdFilters'   => '',
            ],
        ];
    }
}
