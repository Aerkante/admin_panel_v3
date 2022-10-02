<?php

namespace App\Http\Controllers;

class ApiResponse
{

    private static function makeError(...$messages)
    {
        $errors = [];
        foreach ($messages as $key => $value) {
            $errorKey = "error-$key";
            $message = $value;

            if (is_array($value)) {
                if (!is_numeric($value[0])) $errorKey = $value[0];
                $message = $value[1];
            }
            $errors[$errorKey] = [$message];
        }

        return ['errors' => $errors, "status" => "error"];
    }

    public static function returnError($message = null, $code = 400)
    {
        $r = isset($message) ? self::makeError($message) : ['status' => 'error'];
        return response()->json($r, $code);
    }

    public static function returnErrorExp($exp)
    {
        $r = self::makeError(['exp', $exp->getMessage()]);
        $code = $exp->getCode() > 0 && $exp->getCode() < 500 ? $exp->getCode() : 500;
        return response()->json($r, $code);
    }

    public static function returnSuccess($message = null, $data = null)
    {
        $r = ['status' => 'success'];
        $r += isset($message) ? ['message' => $message] : [];
        $r += isset($data) ? ['data' => $data] : [];
        return response()->json($r, 200);
    }

    public static function returnCreated($message = null, $data = null)
    {
        $r = ['status' => 'success'];
        $r += isset($message) ? ['message' => $message] : [];
        $r += isset($data) ? ['data' => $data] : [];
        return response()->json($r, 201);
    }

    public static function returnNoContent()
    {
        return response()->json([], 204);
    }

    public static function returnListContent($data)
    {
        return response()->json($data, 200);
    }

    public static function returnForbbiden($message = null)
    {
        if (!$message) $message = 'Acesso não autorizado.';
        return response()->json(compact('message'), 403);
    }
}
