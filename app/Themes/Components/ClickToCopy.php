<?php

namespace App\Themes\Components;

class ClickToCopy
{
    public string $spanClass  = '';

    public function span(string $attrClass): ClickToCopy
    {
        $this->spanClass    = $attrClass;

        return $this;
    }
}
