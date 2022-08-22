<?php

namespace App\Helpers;

class WeekdayHelper
{
    public static array $weekdays = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];

    public static function weekdaysFlipped(): array
    {
        return array_flip(static::$weekdays);
    }

    public static function weekdaysNames(): array
    {
        return array_values(static::$weekdays);
    }
}
