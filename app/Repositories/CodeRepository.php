<?php

namespace App\Repositories;

use App\Entities\CodeEntity;
use App\Models\Code;
use App\Services\CodeService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CodeRepository
{
    public function __construct(private readonly CodeService $generatorService)
    {
    }

    /**
     * @throws Exception
     */
    public function create(string $prefix): string
    {
        $last = $this->getLastByPrefix($prefix);

        return $last
            ? $this->createNextCode($last)
            : $this->createFirstCode($prefix);
    }

    public function getLastByPrefix(string $prefix): ?string
    {
        try {
            /** @var Code $code */
            $code = Code::query()
                ->where('prefix', $prefix)
                ->orderByDesc('weight')
                ->firstOrFail();
            return $code->lab_code;
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    private function createFirstCode(string $prefix): string
    {
        $code = new Code();
        $code->prefix = $prefix;
        $code->lab_code = $prefix . '000';
        $code->weight = '00.00.000';
        $code->save();

        return $code->lab_code;
    }

    /**
     * @throws Exception
     */
    private function createNextCode(string $code): string
    {
        $codeEntity = new CodeEntity(
            $this->generatorService->increment(new CodeEntity($code))
        );

        $code = new Code();
        $code->prefix = $codeEntity->getPrefix();
        $code->lab_code = $codeEntity->code;
        $code->weight = $codeEntity->getWeight();
        $code->save();

        return $codeEntity->code;
    }
}
