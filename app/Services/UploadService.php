<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UploadService
{
    public static function upload($formFile, $path = 'tradition')
    {
        if (is_string($formFile)) {
            $finalName = Storage::putFile($path, $formFile);
        } else {
            $finalName = Storage::put($path, $formFile);
        }
        if (!$finalName) {
            throw new \Exception("图片上传失败");
        }
        return Storage::url($finalName);
    }
}
