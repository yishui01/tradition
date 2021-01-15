<?php

namespace App\Models;

use App\Models\Traits\ActiveUserHelper;
use App\Models\Traits\LastActivedAtHelper;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use ActiveUserHelper, LastActivedAtHelper, HasFactory, MustVerifyEmailTrait, Notifiable {
        notify as protected laravelNotify;
    }

    // 需要上传的字段，会替换字段值为上传后的url
    public $uploadColumn = ['avatar'];

    // 需要裁剪的图片字段
    public $cutColumn = ['avatar'];

    public static function boot()
    {
        parent::boot();
        self::saving(BaseMode::_savingCallBack());
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'introduction',
        'avatar',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function reply()
    {
        return $this->hasMany(Reply::class);
    }

    public function getAvatarAttribute($value)
    {
        if (empty($value)) {
            return "https://file.wuxxin.com/tradition/x2.jpg";
        }
        return $value;
    }

    /**
     * 重写原有的notify，每一次在调用 $user->notify() 时，自动将 users 表里的 notification_count +1
     * @param $instance
     */
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }
        $this->laravelNotify($instance);
    }

    /**
     * 清空通知
     */
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

}
