@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->excerpt)

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
            <div class="card ">
                <div class="card-body">
                    <div class="text-center">
                        作者：{{ $post->user->name }}
                    </div>
                    <hr>
                    <div class="media">
                        <div align="center">
                            <a href="{{ route('users.show', $post->user->id) }}">
                                <img class="thumbnail img-fluid" src="{{ $post->user->avatar }}" width="300px"
                                     height="300px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 post-content">
            <div class="card ">
                <div class="card-body">
                    <h1 class="text-center mt-3 mb-3">
                        {{ $post->title }}
                    </h1>

                    <div class="article-meta text-center text-secondary">
                        {{ $post->created_at->diffForHumans() }}
                        ⋅
                        <i class="far fa-comment"></i>
                        {{ $post->reply_count }}
                    </div>

                    <div class="post-body mt-4 mb-4">
                        {!! $post->content !!}
                    </div>

                    @can('update', $post)
                        <div class="operate">
                            <hr>
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-secondary btn-sm"
                               role="button">
                                <i class="far fa-edit"></i> 编辑
                            </a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="post"
                                  style="display: inline-block;"
                                  onsubmit="return confirm('您确定要删除吗？');">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-outline-secondary btn-sm">
                                    <i class="far fa-trash-alt"></i> 删除
                                </button>
                            </form>
                        </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
@stop
