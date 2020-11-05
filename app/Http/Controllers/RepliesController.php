<?php

namespace App\Http\Controllers;


use App\Http\Requests\ReplyRequest;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReplyRequest $request, Reply $reply)
    {
        $reply->content = $request->get('content');
        $reply->user_id = Auth::id();
        $reply->post_id = $request->post_id;
        $reply->save();

        return redirect()->to($reply->post->link())->with('success', '评论创建成功！');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();
        return redirect()->to($reply->post->link())->with('success', '评论删除成功！');

    }
}
