<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Link;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'search']]);
    }

    public function index(Request $request, User $user, Link $link)
    {
        /** @var Model $posts */
        $posts = Post::withOrder($request->order)->with("user", "category");
        if ($request->cate) {
            $posts = $posts->where('category_id', $request->cate);
        }
        $posts = $posts->paginate(15);
        $activeUsers = $user->getActiveUsers();
        $links = $link->getAllCached();
        return view('posts.index', compact('posts', 'activeUsers', 'links'));
    }

    public function show(Post $post, Request $request)
    {
        // URL 矫正
        if (!empty($post->slug) && $post->slug != $request->slug) {
            return redirect($post->link(), 301);
        }
        return view('posts.show', compact('post'));
    }

    public function create(Post $post)
    {
        $categories = Category::all();
        return view('posts.create_and_edit', compact('post', 'categories'));
    }

    public function store(PostRequest $request, Post $post)
    {
        $post->fill($request->all());
        $post->user_id = Auth::id();
        $post->save();
        return redirect()->to($post->link())->with('message', 'Created successfully.');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::all();
        return view('posts.create_and_edit', compact('post', 'categories'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->fill($request->all());
        $post->save();
        return redirect()->to($post->link())->with('message', 'Updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('update', $post);
        $post->delete();

        return redirect()->route('posts.index')->with('message', 'Deleted successfully.');
    }

    /**
     * 搜索方法
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        /** @var  $q */
        $q = $request->get('q');
        $pageSize = 100;
        if (empty($q)) {
            $q = "*";
        }
        $res = Post::search($q)->select(["title", "slug", "excerpt", "user_id", "reply_count"])->take($pageSize)
            ->orderBy("reply_count", "desc")->get();
        $res->loadMissing("user");
        $arr = [];
        foreach ($res as $v) {
            /** @var Model $v */
            $v['avatar'] = $v['user']['avatar'];
            $v['url'] = $v->link();
            unset($v['user'], $v['id']);
            $arr[] = $v;
        }
        return $arr;
    }

    public function searchList(Request $request)
    {
        return view('posts.searchList', compact('post', 'categories'));
    }

}
