<?php

namespace App\Enums;

enum OrderStatuses: string
{
    case Unavailable = 'unavailable';
    case Processed = 'processed';

    public static function values(): array
    {
        return [
            self::Unavailable->value,
            self::Processed->value,
        ];
    }
}
