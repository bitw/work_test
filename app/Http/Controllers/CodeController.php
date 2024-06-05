<?php

namespace App\Http\Controllers;

use App\Http\Requests\CodeRequest;
use App\Repositories\CodeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

final class CodeController extends Controller
{
    public function __construct(private readonly CodeRepository $codeRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function make(CodeRequest $request): JsonResponse
    {
        try {
            DB::transaction(function()use($request, &$code){
                $code = $this->codeRepository->create($request->getPrefix());
            }, 3);
            return response()->json(['code' => $code], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
