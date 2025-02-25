<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param mixed $result
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message): JsonResponse
    {
        $response = [
            "success" => true,
            "data" => $result,
            "message" => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * error response method.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError(
        $error,
        $errorMessages = [],
        $code = 404
    ): JsonResponse {
        $response = [
            "success" => false,
            "message" => $error,
        ];

        if (!empty($errorMessages)) {
            $response["data"] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
