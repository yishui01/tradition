<?php

namespace App\Models\Traits;

use App\Models\Post;
use App\Models\Reply;
use app\models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait ActiveUserHelper
{
    protected $users;

    protected $topic_weight = 4; // 话题权重
    protected $reply_weight = 1; // 回复权重
    protected $pass_days = 7; // 多少天内发表过内容
    protected $user_number = 6; // 取出来多少用户

    // 缓存相关配置
    protected $cache_key = "jiayou_users";
    protected $cache_expire_in_seconds = 65 * 60;

    public function getActiveUsers()
    {
        return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function () {
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        // 取得活跃列表
        $active_users = $this->calculateActiveUsers();
        // 并加以缓存
        $this->cacheActiveUsers($active_users);
    }

    public function calculateActiveUsers()
    {
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        $users = Arr::sort($this->users, function ($user) {
            return $user['score'];
        });
        // 倒序，高分靠前，第二个参数为保持数组的KEY不变
        $users = array_reverse($users, true);
        // 取出前几名
        $users = array_slice($users, 0, $this->user_number, true);
        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $user) {
            $user = User::find($user_id);
            if ($user) {
                $active_users->push($user);
            }
        }

        return $active_users;

    }

    public function calculateTopicScore()
    {
        // 从话题数据表里取出限定时间范围（$pass_days）内，有发表过话题的用户
        // 并且同时取出用户此段时间内发布话题的数量
        $topic_users = Post::query()->select(DB::raw('user_id, count(*) as topic_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        // 根据话题数量计算得分
        foreach ($topic_users as $value) {
            $this->users[$value->user_id]['score'] = $value->topic_count * $this->topic_weight;
        }
    }

    private function calculateReplyScore()
    {
        // 从回复数据表里取出限定时间范围（$pass_days）内，有发表过回复的用户
        // 并且同时取出用户此段时间内发布回复的数量
        $reply_users = Reply::query()->select(DB::raw('user_id, count(*) as reply_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        // 根据回复数量计算得分
        foreach ($reply_users as $value) {
            $reply_score = $value->reply_count * $this->reply_weight;
            if (isset($this->users[$value->user_id])) {
                $this->users[$value->user_id]['score'] += $reply_score;
            } else {
                $this->users[$value->user_id]['score'] = $reply_score;
            }
        }
    }

    private function cacheActiveUsers($active_users)
    {
        // 将数据放入缓存中
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_seconds);
    }
}
