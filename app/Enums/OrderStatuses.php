<?php

namespace App\Enums;

enum OrderStatuses: string
{
    case Unavailable = 'Unavailable';
    case Processed = 'Processed';

    public static function values(): array
    {
        return [
            self::Unavailable->value,
            self::Processed->value,
        ];
    }
}
