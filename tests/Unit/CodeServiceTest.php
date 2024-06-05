<?php


use App\Entities\CodeEntity;
use App\Enums\PrefixEnum;
use App\Services\CodeService;
use Tests\TestCase;

final class CodeServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testIncrement(): void
    {
        /** @var CodeService $codeService */
        $codeService = app(CodeService::class);

        $prefix = PrefixEnum::FW->name;

        // Not chars
        $code = "{$prefix}999";
        $entity = new CodeEntity($code);

        $this->assertEquals($code, $entity->code);
        $code = $codeService->increment($entity);
        $this->assertNotEquals($code, $entity->code);

        // Single char
        $code = "{$prefix}999D";
        $entity = new CodeEntity($code);

        $this->assertEquals($code, $entity->code);
        $code = $codeService->increment($entity);
        $this->assertNotEquals($code, $entity->code);

        // Double chars
        $code = "{$prefix}999RM";
        $entity = new CodeEntity($code);

        $this->assertEquals($code, $entity->code);
        $code = $codeService->increment($entity);
        $this->assertNotEquals($code, $entity->code);

        // Single to double chars
        $code = "{$prefix}999Z";
        $entity = new CodeEntity($code);

        $this->assertEquals($code, $entity->code);
        $code = $codeService->increment($entity);
        $this->assertNotEquals($code, $entity->code);

        // Switch double chars to next level (example: CZ -> DA)
        $code = "{$prefix}999CZ";
        $entity = new CodeEntity($code);

        $this->assertEquals($code, $entity->code);
        $code = $codeService->increment($entity);
        $this->assertNotEquals($code, $entity->code);

        // Catch overflow
        $code = "{$prefix}999ZZ";
        $entity = new CodeEntity($code);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Code overflow.');
        $codeService->increment($entity);
    }
}
