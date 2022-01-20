<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function response($data)
    {
        return response(...func_get_args());
    }


    public function responseJson($data): \Illuminate\Http\JsonResponse
    {

        return response()->json($data);

    }
}
