<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;

class ImageService
{

    /**
     * 裁剪上传的图片
     * @param $file UploadedFile
     * @param $max_width
     * @return string
     */
    public static function cutSize($file, $max_width)
    {
        $file_path = $file->getPathname();
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {
            /** @var Constraint $constraint */

            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $name = public_path(md5(microtime() . mt_rand(1, 10000)) . '.' . $extension);
        $image->save($name);
        return $name;
    }
}
