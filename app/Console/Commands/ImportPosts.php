<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Services\WxCrawlerService;
use Goutte\Client;
use Illuminate\Console\Command;

class ImportPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import posts to ES';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        foreach (config('app.post-urls') as $url) {
            if (Post::where('url', $url)->exists()) {
                continue;
            }
            $domArr = WxCrawlerService::crawByUrl("https://mp.weixin.qq.com/s/Ck8GSDfZcuzKk8kaUj0adg");
            $this->savePost($domArr);
            $this->info('create one post!');
        }
    }

    protected function savePost($domArr)
    {
        Post::create([
            'url'       => $domArr['content_url'],
            'author'    => $domArr['author'],
            'title'     => $domArr['title'],
            'content'   => $domArr['content_html'],
            'post_date' => date('Y-m-d H:i:s', $domArr['date']),
        ]);
    }
}
