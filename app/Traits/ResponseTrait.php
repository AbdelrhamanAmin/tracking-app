<?php

namespace App\Traits;
use Illuminate\Http\Response;

trait ResponseTrait {

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function success($message = null, $statusCode = Response::HTTP_OK, $data = [])
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $data
        ];
        return response()->json($response, $statusCode);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function error($message = null, $statusCode = Response::HTTP_FORBIDDEN, $errors = [])
    {
        $response = [
            'success' => false,
            'message' => $message,
            'data'    => $errors
        ];

        return response()->json($response, $statusCode);
    }
}
