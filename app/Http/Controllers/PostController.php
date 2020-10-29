<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\WxCrawlerService;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Psr\Log\Test\LoggerInterfaceTest;

class PostController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->get('q');
        $paginator = [];
        if ($q) {
            $paginator = Post::search($q)->paginate();
        }

        return view('search', compact('paginator', 'q'));
    }

    public function test()
    {
        /**
         *
         * $url = 'https://mp.weixin.qq.com/s/4gwonJ3m0wd-kwTA3SmU-g';
         * $crawler = new WxCrawler();
         * $content = $crawler->crawByUrl($url);
         * echo $content['content_html'];
         */
        dd(WxCrawlerService::crawByUrl("https://mp.weixin.qq.com/s/Ck8GSDfZcuzKk8kaUj0adg"));
    }
}




