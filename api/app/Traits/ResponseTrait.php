<?php

namespace App\Traits;

trait ResponseTrait
{
    public function responseSuccess($responseCode, $message, $data = [])
    {
        return response()->json([
            'status'    => true,
            'message'   => $message,
            'data'      => $data
        ], $responseCode);
    }
    public function responseValidationError($responseCode, $message, $errors = [])
    {
        return response()->json([
            'status'    => false,
            'message'   => $message,
            'errors'    => $errors
        ], $responseCode);
    }

    public function responseError($responseCode, $message)
    {
        return response()->json([
            'status'    => false,
            'message'   => $message,
        ], $responseCode);
    }

    public function resposeWithExpectationFailed($responseCode, $message = 'Something went wrong')
    {
        return response()->json([
            'status'        => false,
            'message'       => $message,
        ], $responseCode);
    }

    public function responseWithToken($responseCode, $token, $user, $expiresAt)
    {
        return response()->json([
            'status'        => true,
            'message'       => 'Logged in successfully',
            'user'          => $user,
            'token'         => $token,
            'expires_at'    => $expiresAt
        ], $responseCode);
    }
}
