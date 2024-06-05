<?php

namespace Tests\Unit;

use App\Entities\CodeEntity;
use App\Enums\PrefixEnum;
use App\Models\Code;
use App\Repositories\CodeRepository;
use Exception;
use Tests\TestCase;

final class CodeEntityTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCodeEntity(): void
    {
        /** @var CodeRepository $codeRepository */
        $codeRepository = app(CodeRepository::class);

        $prefix = PrefixEnum::random()->name;

        $code = $codeRepository->create($prefix);

        /** @var Code $codeModel */
        $codeModel = Code::query()->where("lab_code", $code)->first();

        $entity = new CodeEntity($code);

        $this->assertEquals($code, $entity->code);
        $this->assertEquals($prefix, $entity->getPrefix());
        $this->assertEquals($codeModel->weight, $entity->getWeight());

        $entity = new CodeEntity($prefix.'999ZZ');
        $this->assertEquals('26.26.999', $entity->getWeight());
    }
}
