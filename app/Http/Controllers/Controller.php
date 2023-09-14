<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected const PAGINATION_COUNT = 10;

    protected function handleResponse(bool $status, $message = 'Success'): JsonResponse{
            return $status ?
                response()->json(['message' => $message]) :
                response()->json(['message' => $message], 404);
    }
}
