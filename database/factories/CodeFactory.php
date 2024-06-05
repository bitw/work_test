<?php

namespace Database\Factories;

use App\Entities\CodeEntity;
use App\Enums\PrefixEnum;
use App\Models\Code;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Code>
 */
class CodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $codeEntity = new CodeEntity(
            PrefixEnum::random()->name .
            $this->getRandomNumber() .
            $this->getRandomChars()
        );
        return [
            'prefix' => $codeEntity->getPrefix(),
            'lab_code' => $codeEntity->code,
            'weight' => $codeEntity->getWeight(),
        ];
    }

    public function withPrefix(string $prefix): static
    {
        return $this->state([
            'prefix' => $prefix,
        ]);
    }

    private function getRandomNumber(): string
    {
        return Str::padLeft((string)mt_rand(0, 999), 3, '0');
    }

    private function getRandomChars(): string
    {
        $length = mt_rand(0, 2);

        if (!$length) {
            return '';
        }
        $chars = '';

        for ($i = 0; $i < $length; $i++) {
            $chars .= chr(mt_rand(ord('A'), ord('Z')));
        }

        return $chars;
    }
}
