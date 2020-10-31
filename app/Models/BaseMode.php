<?php

namespace App\Models;

use App\Services\ImageService;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BaseMode extends Model
{

    public static function boot()
    {
        parent::boot();
        self::saving(self::savingCallBack());
    }

    /**
     * 模型保存前回调
     * @return \Closure
     */
    public static function savingCallBack()
    {
        /** @var  $model Model */
        return function ($model) {
            $uploadColumn = $model->uploadColumn ?? [];
            $cutColumn = $model->cutColumn ?? [];
            foreach ($model->getAttributes() as $k => $v) {
                if (in_array($k, $uploadColumn)) {
                    // 需要上传
                    $file = $v;
                    if (in_array($k, $cutColumn)) {
                        //需要裁剪
                        $file = ImageService::cutSize($v, 416);
                    }
                    $model->$k = $s = UploadService::upload($file);
                    unlink($file);
                }
            };
        };
    }
}
