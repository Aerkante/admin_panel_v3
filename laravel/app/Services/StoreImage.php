<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;

class StoreImage
{
    public function storeBase64($base64, $disk, $name)
    {
        $regex = "/data:image\/\w+;base64,(?<bin>.+)/";
        preg_match($regex, $base64, $res);
        $parsedBase = $res['bin'] ?? null;

        if (!$parsedBase) {
            throw new Exception('Invalid base64');
        }

        $imageFromString = imagecreatefromstring(base64_decode($parsedBase));

        $file = tempnam(sys_get_temp_dir(), $name);
        imagepng($imageFromString, $file, 9);
        rename($file, "$disk/$name");
    }

    public function storeFile(UploadedFile $file, $disk, $name)
    {
        $file->move($disk, $name);
    }
}
