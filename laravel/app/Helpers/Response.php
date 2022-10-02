<?php

namespace App\Helpers;

class Response
{
    public static function created($data)
    {
        return self::response($data, 201);
    }

    public static function success($data)
    {
        return self::response($data, 200);
    }

    public static function notFound($data)
    {
        return self::response($data, 404);
    }

    public static function serverError()
    {
        return self::response(['message' => 'Ocorreu um erro, tente novamente mais tarde.'], 500);
    }

    public static function badRequest($data)
    {
        return self::response($data, 400);
    }

    public static function unauthorized($data = ['message' => 'Acesso não autorizado.'])
    {
        return self::response($data, 401);
    }

    public static function forbidden($data = ['message' => 'Ação não permitida.'])
    {
        return self::response($data, 403);
    }

    public static function noContent()
    {
        return self::response([], 204);
    }

    public static function stream($makeFile, $headers = [])
    {
        return response()->stream($makeFile, 200, $headers);
    }

    private static function response($data, $status)
    {
        return response()->json($data, $status);
    }
}
