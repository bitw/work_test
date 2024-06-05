<?php

namespace App\Http\Requests;

use App\Enums\PrefixEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        /** @var string $prefix */
        $prefix = $this->input('prefix');
        $this->request->replace([
            'prefix' => Str::upper($prefix),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'prefix' => 'required|string|in:' . implode(',', PrefixEnum::names()),
        ];
    }

    public function getPrefix(): string
    {
        /** @var string $prefix */
        $prefix = $this->input('prefix');
        return $prefix;
    }
}
