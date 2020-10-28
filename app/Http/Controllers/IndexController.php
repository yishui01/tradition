<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;

class IndexController extends Controller
{
    public function index()
    {
        $hosts = [
            '121.36.244.220:9200',         // IP + Port
        ];
        $client = ClientBuilder::create()           // Instantiate a new ClientBuilder
        ->setHosts($hosts)      // Set the hosts
        ->build();
        return $a;
    }
}
