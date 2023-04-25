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

/** @codeCoverageIgnore */
abstract class AbstractTheme
{
    public Table $table;

    public Checkbox $checkbox;

    public Layout $layout;

    public Actions $actions;

    public Editable $editable;

    public ClickToCopy $clickToCopy;

    public Toggleable $toggleable;

    public FilterBoolean $filterBoolean;

    public FilterSelect $filterSelect;

    public FilterDatePicker $filterDatePicker;

    public FilterMultiSelect $filterMultiSelect;

    public FilterNumber $filterNumber;

    public FilterInputText $filterInputText;

    public Footer $footer;

    public Cols $cols;

    public function table(): Table
    {
        return Theme::table('');
    }

    public function checkbox(): Checkbox
    {
        return Theme::checkbox();
    }

    public function footer(): Footer
    {
        return Theme::footer();
    }

    public function editable(): Editable
    {
        return Theme::editable();
    }

    public function clickToCopy(): ClickToCopy
    {
        return Theme::clickToCopy();
    }

    public function cols(): Cols
    {
        return Theme::cols();
    }

    public function actions(): Actions
    {
        return Theme::actions();
    }

    public function layout(): ?Components\Layout
    {
        return Theme::layout();
    }

    public function toggleable(): Toggleable
    {
        return Theme::toggleable();
    }

    public function filterBoolean(): FilterBoolean
    {
        return Theme::filterBoolean();
    }

    public function filterDatePicker(): FilterDatePicker
    {
        return Theme::filterDatePicker();
    }

    public function filterMultiSelect(): FilterMultiSelect
    {
        return Theme::filterMultiSelect();
    }

    public function filterNumber(): FilterNumber
    {
        return Theme::filterNumber();
    }

    public function filterSelect(): FilterSelect
    {
        return Theme::filterSelect();
    }

    public function filterInputText(): FilterInputText
    {
        return Theme::filterInputText();
    }
}
