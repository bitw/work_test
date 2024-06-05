<?php

namespace Tests\Unit;

use App\Enums\PrefixEnum;
use App\Models\Code;
use App\Repositories\CodeRepository;
use Exception;
use Tests\TestCase;

final class CodeRepositoryTest extends TestCase
{
    private CodeRepository $codeRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->codeRepository = app(CodeRepository::class);
    }

    /**
     * @throws Exception
     */
    public function testCreateAsFirstCode(): void
    {
        $prefix = PrefixEnum::random()->name;
        $this->codeRepository->create($prefix);

        $this->assertDatabaseHas('codes', [
            'prefix' => $prefix,
            'lab_code' => $prefix . '000'
        ]);
    }

    /**
     * @throws Exception
     */
    public function testCreateAsNextCode(): void
    {
        $code = Code::factory()->create();

        /** @var Code $code */
        $code = Code::query()->where('lab_code', $code->lab_code)->first();

        $nextCode = $this->codeRepository->create($code->prefix);

        $this->assertDatabaseHas('codes', ['lab_code' => $nextCode]);
    }
}
