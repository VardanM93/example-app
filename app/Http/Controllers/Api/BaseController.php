<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

/**
 * Class BaseController
 * @package App\Http\Controllers\Api
 */
class BaseController extends Controller
{
    /**
     * Returned All Of responses
     * @param $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function response($data)
    {
        return response(...func_get_args());
    }

}
