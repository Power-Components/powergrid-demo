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
use Illuminate\Support\Facades\Facade;

/**
 * @method static Table table(string $attrClass, string $attrStyle='')
 * @method static Footer footer()
 * @method static Toggleable toggleable()
 * @method static Layout layout()
 * @method static Cols cols()
 * @method static Actions actions()
 * @method static Checkbox checkbox()
 * @method static Editable editable()
 * @method static ClickToCopy clickToCopy()
 * @method static FilterBoolean filterBoolean()
 * @method static FilterDatePicker filterDatePicker()
 * @method static FilterMultiSelect filterMultiSelect()
 * @method static FilterNumber filterNumber()
 * @method static FilterSelect filterSelect()
 * @method static FilterInputText filterInputText()
 *
 * @see \namespace App\Themes\ThemeManager
 */
class Theme extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'theme';
    }
}
