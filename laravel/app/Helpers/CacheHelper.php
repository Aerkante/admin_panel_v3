<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CacheHelper
{
    public static function getTime($minutes)
    {
        $time = Carbon::now();
        $time->addMinutes($minutes);

        return $time;
    }

    public static function getKey(Request $request = null, string $posfix = '', $allUsers = false)
    {
        $key = '';
        if ($request) {
            $key = json_encode($request->all());
            $key .= $request->getUri();
        }

        if (!$allUsers) {
            $user = Auth::user();
            $key .= $user->id ?? 79;
        }

        if ($posfix) {
            $key .= $posfix;
        }
        if (!$key) {
            $key = time();
        }

        return md5($key);
    }
}
