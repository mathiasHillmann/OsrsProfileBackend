<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function response($data = [], int $status = HttpFoundationResponse::HTTP_OK, string $message = null): JsonResponse
    {
        if ($data instanceof \Throwable) {
            $status = HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR;

            return Response::json(['message' => $message, 'error' => $data->getMessage(), 'file' => $data->getFile(), 'line' => $data->getLine()], $status);
        } else {
            return Response::json(['message' => $message, 'data' => $data], $status);
        }
    }
}
