<?php

namespace App\Traits;

trait JsonResponeses
{
    // Return JsonResponse Success
    public function success($data, $message = "Success", $token)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $data
        ]);
    }

    // Return JsonResponse Error
    public function error($data, $message = "Error", $code = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
