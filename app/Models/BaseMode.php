<?php

namespace App\Models;

use App\Services\ImageService;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class BaseMode extends EloquentModel
{

    public static function boot()
    {
        parent::boot();
        self::saving(static::savingCallBack());
        self::saved(static::savedCallback());
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
                if (in_array($k, $uploadColumn) && $v instanceof UploadedFile) {
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

    public static function savedCallback()
    {
        /** @var  $model Model */
        return function ($model) {

        };
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'desc');
    }
}
