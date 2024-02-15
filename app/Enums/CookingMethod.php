<?php

namespace App\Enums;

enum CookingMethod: int
{
    case BAKED = 0;
    case ROASTED = 1;
    case GRILLED = 2;
    case DEEP_FRIED = 3;
    case BOILED = 4;
    case STEAMED = 5;

    public function labels(): string
    {
        return match ($this) {
            self::BAKED => _('Baked'),
            self::ROASTED => _('Roasted'),
            self::GRILLED => _('Grilled'),
            self::DEEP_FRIED => _('Deep fried'),
            self::BOILED => _('Boiled'),
            self::STEAMED => _('Steamed'),
        };
    }
}
