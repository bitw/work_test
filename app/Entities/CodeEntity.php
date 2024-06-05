<?php

namespace App\Entities;

use Illuminate\Support\Str;

class CodeEntity
{
    public function __construct(
        public readonly string $code,
    ) {
    }

    public function getPrefix(): string
    {
        return Str::substr($this->code, 0, 2);
    }

    public function getNumbers(): string
    {
        preg_match('/^(\d{3})/', Str::substr($this->code, 2, 3), $matches);

        return str_pad($matches[0], 3, '0', STR_PAD_LEFT);
    }

    public function getChars(): string
    {
        preg_match('/([A-Z]{0,2})$/', $this->code, $matches);
        return $matches[0];
    }

    public function getWeight(): string
    {
        $chars = Str::reverse($this->getChars());

        $char1 = $char2 = '00';
        if (isset($chars[1])) {
            $char1 = Str::padLeft((string)(ord($chars[1]) - 64), 2, '0');
        }

        if (isset($chars[0])) {
            $char2 = Str::padLeft((string)(ord($chars[0]) - 64), 2, '0');
        }

        return sprintf('%s.%s.%s', $char1, $char2, $this->getNumbers());
    }
}
