<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * @function onResponse
     * @summary for success response
     */
    public function onSuccess($message, $data = [], $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * @function onBadResponse
     * @summary for failed response
     */
    public function onFailed($message, $data = [], $code = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
