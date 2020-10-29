<?php


return [
    'client'           => [
        //Elasticsearch/ClientBuilder.php 中有setXXX方法都可以在这里配置xxx属性，比如文件中有setLogger方法，这里就能配置logger
        'hosts'  => [
            env('ELASTICSEARCH_HOST', 'localhost:9200'),
        ],
        'logger' => app('log'),
        'tracer' => app('log')
    ],
    'update_mapping'   => env('SCOUT_ELASTIC_UPDATE_MAPPING', true),
    'indexer'          => env('SCOUT_ELASTIC_INDEXER', 'single'),
    'document_refresh' => env('SCOUT_ELASTIC_DOCUMENT_REFRESH', true),
];
