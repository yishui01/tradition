<?php

namespace App\Models;

use App\Jobs\TranslateSlug;
use App\PostsIndexConfigurator;
use App\Services\PostService;
use Illuminate\Database\Query\Builder;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends BaseMode
{
    use HasFactory, Searchable;

    protected $indexConfigurator = PostsIndexConfigurator::class;

    protected $searchRules = [
        //
    ];

    public static function savingCallBack()
    {
        return function ($model) {
            $model->content = clean($model->content); // 过滤有威胁的html标签，防止XSS
            if (!$model->excerpt) {
                $model->excerpt = make_excerpt($model->content);
            }
            parent::savingCallBack()($model);
        };
    }

    public static function savedCallback()
    {
        return function ($model) {
            if (!$model->slug) {
                dispatch(new TranslateSlug($model));
            }
            parent::savedCallback()($model);
        };
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'post_date'  => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'title',
        'url',
        'slug',
        'author',
        'content',
        'post_date',
        'category_id',
        'reply_count',
        'view_count',
        'last_reply_user_id',
        'order',
        'excerpt',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(function ($user) {
            $user->name = '游客';
            $user->avatar = 'https://file.wuxxin.com/tradition/l1.jpg';
        });
    }

    public function link($params = [])
    {
        return route('posts.show', array_merge([$this->id, $this->slug], $params));
    }

    /**
     * @param $query Builder
     * @param $order
     */
    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }
    }

    /**
     * @param $query Builder
     * @return mixed
     */
    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * @param $query Builder
     * @return mixed
     */
    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }


    // Here you can specify a mapping for model fields
    protected $mapping = [
        'properties' => [
            "title"              => [
                "type"     => "text",
                "analyzer" => "ik_max_word",
            ],
            "url"                => [
                "type"     => "text",
                "analyzer" => "ik_smart",
            ],
            "author"             => [
                "type"     => "text",
                "analyzer" => "ik_smart",
            ],
            "content"            => [
                "type"     => "text",
                "analyzer" => "ik_max_word",
            ],
            "excerpt"            => [
                "type"     => "text",
                "analyzer" => "ik_max_word",
            ],
            "slug"               => [
                "type" => "keyword",
            ],
            "user_id"            => [
                "type" => "integer",
            ],
            "category_id"        => [
                "type" => "integer",
            ],
            "reply_count"        => [
                "type" => "integer",
            ],
            "view_count"         => [
                "type" => "integer",
            ],
            "nice_count"         => [
                "type" => "integer",
            ],
            "last_reply_user_id" => [
                "type" => "integer",
            ],
            "order"              => [
                "type" => "integer",
            ],
            "post_date"          => [
                "type"   => "date",
                "format" => "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis",
            ],
            "created_at"         => [
                "type"   => "date",
                "format" => "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis",
            ],
            "updated_at"         => [
                "type"   => "date",
                "format" => "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis",
            ],
        ]
    ];
}
