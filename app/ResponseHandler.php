<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponseHandler extends Model
{
    public function send($status = 200, $message, $data = []) {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function notFound($message) {
        return response()->json([
            'status' => 404,
            'message' => "$message not found",
        ]);
    }

    public function internalError() {
        return response()->json([
            'status' => 500,
            'message' => "Internal server error",
        ]);
    }

    public function exists($message) {
        return response()->json([
            'status' => 400,
            'message' => "$message already exists",
        ]);
    }

    public function validateError($errors) {
        
        return response()->json([
            'status' => 422,
            'message' => 'Validation errors',
            'error' => $errors
        ]);
    }

    public function badCredentials() {
        
        return response()->json([
            'status' => 401,
            'message' => 'Username or password is wrong',
        ]);
    }
}
