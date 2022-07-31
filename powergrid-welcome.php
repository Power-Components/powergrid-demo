<?php

declare(strict_types = 1);

define('RUN_STATUS', 'ran');

runOnce();

$green    = "\033[0;32m";
$yellow   = "\033[0;33m";
$noColor  = "\033[0m";

echo <<<EOF

{$yellow} __{$green}     ____                          ______     _     __
{$yellow}/ /_,{$green}  / __ \____ _      _____  _____/ ____/____(_)___/ /
{$yellow}/_ ,'{$green} / /_/ / __ \ | /| / / _ \/ ___/ / __/ ___/ / __  / 
{$yellow}/'{$green}   / ____/ /_/ / |/ |/ /  __/ /  / /_/ / /  / / /_/ /  
    /_/    \____/|__/|__/\___/_/   \____/_/  /_/\__,_/     


{$noColor}Welcome and thank you for downloading our Demo!


👀 Check the {$yellow}PowerGrid Table{$noColor} at: {$green}[{$yellow}app/Http/Livewire/DishesTable.php{$green}]{$noColor}.

📚 See the Documentation at {$yellow}https://livewire-powergrid.com/{$noColor} for more information.

⭐ Please consider {$yellow}starring{$noColor} our repository at {$yellow}https://github.com/Power-Components/livewire-powergrid{$noColor} ⭐


EOF;

/*
|*********************************************************************
|                     PHP Version Compatibility
|*********************************************************************
| Although PowerGrid Demo repository requires PHP 8.0 as minimum version,
| we have decided to include a commented version of the 'Enum Filter' feature.
| Enum is available from Php 8.1+ and the script below removes comments 
| in certain files, guaranteeing that nothing will break for your PHP version.
*/

if (version_compare(PHP_VERSION, '8.1', '>')) {
    $files = ['app/Enums/Diet.php', 'app/Http/Livewire/DishesTable.php'];

    foreach ($files as $filePath) {
        $filePath = str_replace('\\', DIRECTORY_SEPARATOR, __DIR__ . '\\' . $filePath);

        $fileContent = file_get_contents($filePath);

        $fileContent = preg_replace('/^.*Only from Php 8.1[^\\n]*/m', '', $fileContent);

        file_put_contents($filePath, $fileContent);
    }
}

/*
|*********************************************************************
|          This script should run only once
|*********************************************************************
*/

function runOnce(): void
{
    if (RUN_STATUS == 'ran') {
        exit(0);
    }

    $fileContent = str_replace('never' . '_ran', 'ran', file_get_contents(__FILE__));
    file_put_contents(__FILE__, $fileContent);
}