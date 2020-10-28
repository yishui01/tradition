<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class PostsIndexConfigurator extends IndexConfigurator
{

    use Migratable;

    /**
     * @var array
     */
    protected $settings = [
        'number_of_shards'   => 1,
        'number_of_replicas' => 0,
    ];
}
