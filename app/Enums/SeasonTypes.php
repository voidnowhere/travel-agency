<?php

namespace App\Enums;

enum SeasonTypes: string
{
    case Special = 'Special';
    case High = 'High';
    case Medium = 'Medium';
    case Low = 'Low';

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
