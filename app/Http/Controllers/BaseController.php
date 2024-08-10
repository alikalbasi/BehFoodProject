<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function successResponse($data, $code=200)
    {
        $response=[
            'message'=>$data,
            'status'=>'success',
        ];
        return response()->json($response, $code);

    }
    public function errorResponse($data, $code=404)
    {
        $response=[
            'message'=>$data,
            'status'=>'error',
        ];
        return response()->json($response, $code);

    }
}
