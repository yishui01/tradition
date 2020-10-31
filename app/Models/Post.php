<?php

namespace App\Models;

use App\PostsIndexConfigurator;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends BaseMode
{
    use HasFactory, Searchable;

    protected $indexConfigurator = PostsIndexConfigurator::class;

    protected $searchRules = [
        //
    ];

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
        'user_id',
        'category_id',
        'reply_count',
        'view_count',
        'last_reply_user_id',
        'order',
        'excerpt',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
