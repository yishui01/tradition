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

    // Here you can specify a mapping for model fields
    protected $mapping = [
        'properties' => [
            "title"      => [
                "type"     => "text",
                "analyzer" => "ik_max_word",
            ],
            "url"        => [
                "type"     => "text",
                "analyzer" => "ik_smart",
            ],
            "author"     => [
                "type"     => "text",
                "analyzer" => "ik_smart",
            ],
            "content"    => [
                "type"     => "text",
                "analyzer" => "ik_max_word",
            ],
            "post_date"  => [
                "type"   => "date",
                "format" => "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis",
            ],
            "created_at" => [
                "type"   => "date",
                "format" => "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis",
            ],
            "updated_at" => [
                "type"   => "date",
                "format" => "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis",
            ],
        ]
    ];

    protected $fillable = [
        'url',
        'author',
        'title',
        'content',
        'post_date'
    ];

    public function toSearchableArray()
    {
        return [
            'title'   => $this->title,
            'content' => $this->content
        ];
    }
}
