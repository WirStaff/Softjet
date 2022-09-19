<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class V1Controller extends Controller
{
    public function success($data = []): JsonResponse
    {
        return response()->json($data);
    }
}
