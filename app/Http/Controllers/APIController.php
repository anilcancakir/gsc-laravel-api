<?php

namespace App\Http\Controllers;

class APIController extends Controller
{
    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data) {
        return response()->json(['status' => 'ok', 'data' => $data]);
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message, $code = 500) {
        return response()->json(['status' => 'error', 'data' => null, 'error' => $message], $code);
    }
}
