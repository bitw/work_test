<?php

namespace App\Enums;

enum PrefixEnum
{
    case QD;
    case ZA;
    case FW;

    /**
     * @return array<string>
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function random(): self
    {
        $count = count(self::cases()) - 1;

        return self::cases()[rand(0, $count)];
    }
}
