<?php

namespace App\Enums;

enum SeasonTypes: string
{
    case Special = 'special';
    case High = 'high';
    case Medium = 'medium';
    case Low = 'low';

    public static function values(): array
    {
        return [
            self::Special->value,
            self::High->value,
            self::Medium->value,
            self::Low->value,
        ];
    }
}
