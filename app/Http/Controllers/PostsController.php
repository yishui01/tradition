<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'search']]);
    }

    public function index(Request $request)
    {
        /** @var Model $posts */
        $posts = Post::withOrder($request->order)->with("user", "category");
        if ($request->cate) {
            $posts = $posts->where('category_id', $request->cate);
        }
        $posts = $posts->paginate(15);
        return view('posts.index', compact('posts'));
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

    public function search(Request $request)
    {
        $q = $request->get('q');
        $pageSize = 10;
        if ($q) {
            $res = Post::search($q)->take($pageSize)->get();
        } else {
            $res = Post::take($pageSize)->get();
        }
        return $res;
    }

}
