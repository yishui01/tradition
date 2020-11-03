<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
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

    public function show(Post $post)
    {
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
        return redirect()->route('posts.show', $post->id)->with('message', 'Created successfully.');
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
        return redirect()->route('posts.show', $post->id)->with('message', 'Updated successfully.');
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
        $paginator = [];
        if ($q) {
            $paginator = Post::search($q)->paginate();
        }

        return view('search', compact('paginator', 'q'));
    }

}
