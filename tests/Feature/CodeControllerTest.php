<?php

namespace Tests\Feature;

use App\Enums\PrefixEnum;
use App\Repositories\CodeRepository;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class CodeControllerTest extends TestCase
{
    public function testMakeSuccess(): void
    {
        /** @var CodeRepository $codeRepository */
        $codeRepository = app(CodeRepository::class);

        $prefix = PrefixEnum::FW->name;

        $response = $this->post(route('code.make'), ['prefix' => $prefix]);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['code' => $codeRepository->getLastByPrefix($prefix)]);
    }

    public function testMakeErrorPrefix(): void
    {
        $response = $this->post(route('code.make'), ['prefix' => Str::random()]);

        $response->assertUnprocessable()
        ->assertJsonStructure([
            'message',
            'errors' => ['prefix']
        ]);
    }
}
