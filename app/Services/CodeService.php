<?php

namespace App\Services;

use App\Entities\CodeEntity;
use Exception;
use Illuminate\Support\Str;

class CodeService
{
    private const MAX_NUMBER = 999;
    private const MIN_CHAR = 'A';
    private const MAX_CHAR = 'Z';

    /**
     * @throws Exception
     */
    public function increment(CodeEntity $codeEntity): string
    {
        $numbers = (int)$codeEntity->getNumbers();
        $chars = $codeEntity->getChars();

        if (++$numbers > self::MAX_NUMBER) {
            $numbers = '000';
            $chars = $this->incrementChars($chars);
        } else {
            $numbers = str_pad((string)$numbers, 3, '0', STR_PAD_LEFT);
        }

        return $codeEntity->getPrefix() . $numbers . $chars;
    }

    /**
     * @throws Exception
     */
    private function incrementChars(string $chars): string
    {
        if (!$chars) {
            return self::MIN_CHAR;
        }

        if ($chars === (self::MAX_CHAR . self::MAX_CHAR)) {
            throw new Exception('Code overflow.');
        }

        $incrementChar = fn ($char) => chr(ord($char) + 1);

        if (Str::length($chars) === 1 && $chars !== self::MAX_CHAR) {
            $chars = $incrementChar($chars);
        } elseif (Str::length($chars) === 1 && $chars === self::MAX_CHAR) {
            $chars = self::MIN_CHAR . self::MIN_CHAR;
        } elseif (Str::length($chars) > 1) {
            $firstChar = Str::substr($chars, 0, 1);
            $lastChar = Str::substr($chars, Str::length(($chars)) - 1, 1);

            if ($lastChar !== self::MAX_CHAR) {
                $chars = $firstChar . $incrementChar($lastChar);
            } else {
                $chars = $incrementChar($firstChar) . self::MIN_CHAR;
            }
        }

        return $chars;
    }
}
