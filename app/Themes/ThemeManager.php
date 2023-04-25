<?php

namespace App\Themes;

use App\Themes\Components\Actions;
use App\Themes\Components\Checkbox;
use App\Themes\Components\ClickToCopy;
use App\Themes\Components\Cols;
use App\Themes\Components\Editable;
use App\Themes\Components\FilterBoolean;
use App\Themes\Components\FilterDatePicker;
use App\Themes\Components\FilterInputText;
use App\Themes\Components\FilterMultiSelect;
use App\Themes\Components\FilterNumber;
use App\Themes\Components\FilterSelect;
use App\Themes\Components\Footer;
use App\Themes\Components\Layout;
use App\Themes\Components\Table;
use App\Themes\Components\Toggleable;

class ThemeManager
{
    public function table(string $attrClass, string $attrStyle = ''): Table
    {
        return new Table($attrClass, $attrStyle);
    }

    public function actions(): Actions
    {
        return new Actions;
    }

    public function cols(): Cols
    {
        return new Cols;
    }

    public function footer(): Footer
    {
        return new Footer;
    }

    public function toggleable(): Toggleable
    {
        return new Toggleable;
    }

    public function checkbox(): Checkbox
    {
        return new Checkbox;
    }

    public function editable(): Editable
    {
        return new Editable;
    }

    public function clickToCopy(): ClickToCopy
    {
        return new ClickToCopy;
    }

    public function layout(): Layout
    {
        return new Layout;
    }

    public function filterBoolean(): FilterBoolean
    {
        return new FilterBoolean;
    }

    public function filterDatePicker(): FilterDatePicker
    {
        return new FilterDatePicker;
    }

    public function filterMultiSelect(): FilterMultiSelect
    {
        return new FilterMultiSelect;
    }

    public function filterNumber(): FilterNumber
    {
        return new FilterNumber;
    }

    public function filterSelect(): FilterSelect
    {
        return new FilterSelect;
    }

    public function filterInputText(): FilterInputText
    {
        return new FilterInputText;
    }
}
