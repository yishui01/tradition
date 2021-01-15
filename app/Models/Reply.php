<?php

namespace App\Models;

use App\Exceptions\UserInvalidException;
use App\Exceptions\UserException;
use App\Notifications\PostReplied;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Reply extends BaseMode
{
    use HasFactory, SoftDeletes;

    public function post()
    {
        return $this->belongsTo(Post::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public static function savingCallBack()
    {
        return function ($model) {
            $content = clean($model->content, 'user_topic_body');
            if (!$content) {
                throw new UserInvalidException("请输入评论内容");
            }
            $model->content = $content;
            // 构建path
            $path = '-' . $model->id . '-';
            if ($model->parent_id != 0) {
                $parent = Reply::find($model->parent_id);
                if ($parent) {
                    $path .= $model->id . '-';
                } else {
                    $path = '';
                }
            }
            $model->path = $path;
        };
    }

    public static function savedCallback()
    {
        return function ($model) {
            // 通知话题作者有新的评论
            /** @var User $postAuthor */
            $postAuthor = $model->post->user;
            $postAuthor->notify(new PostReplied($model));

            // 更新文章评论数
            /** @var Post $post */
            $post = $model->post;
            if ($post->id) {
                $post->updateReplyCount();
            }
        };
    }

    public static function boot()
    {
        parent::boot();
        self::deleted(function ($model) {
            $model->post->updateReplyCount();
        });
    }
}
