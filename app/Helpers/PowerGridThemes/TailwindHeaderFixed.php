<?php

namespace App\Helpers\PowerGridThemes;

use PowerComponents\LivewirePowerGrid\Themes\DaisyUI;

class TailwindHeaderFixed extends DaisyUI
{
    public function table(): array
    {
        return [
            'layout' => [
                'base'      => 'p-3 align-middle inline-block min-w-full w-full sm:px-6 lg:px-8',
                'div'       => 'max-h-[29rem] rounded-t-lg relative border-x border-t border-bg-base-200',
                'table'     => 'table table-zebra',
                'container' => '-my-2 overflow-x-auto sm:-mx-3 lg:-mx-8',
                'actions'   => 'flex gap-2',
            ],

            'header' => [
                'thead'    => 'sticky -top-[0.3px] relative',
                'tr'       => 'bg-base-200',
                'th'       => '',
                'thAction' => '',
            ],

            'body' => [
                'tbody'              => '',
                'tbodyEmpty'         => '',
                'tr'                 => '',
                'td'                 => '',
                'tdEmpty'            => '',
                'tdSummarize'        => '',
                'trSummarize'        => '',
                'tdFilters'          => '',
                'trFilters'          => '',
                'tdActionsContainer' => 'flex gap-2',
            ],
        ];
    }
}
