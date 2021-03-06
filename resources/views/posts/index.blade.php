@extends('layouts.app')

@section('title', isset($category) ? $category->title : '话题列表')

@section('content')

    <div class="row mb-5">
        <div class="col-lg-9 col-md-9 post-list">
            @if (count($posts) > 0 && $category = $posts[0]->category)
                <div class="alert alert-info" role="alert">
                    {{ $category->title }} ：{{ $category->introduction }}
                </div>
            @endif
            <div class="card ">

                <div class="card-header bg-transparent">
                    <ul class="nav nav-pills">
                        <li class="nav-item ">
                            <a class="nav-link {{checkQuery("order","recent",true)}} "
                               href="?order=default">
                                最后回复
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{checkQuery("order","recent")}} "
                               href="?order=recent">
                                最新发布
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    {{-- 话题列表 --}}
                    @include('posts._post_list', ['posts' => $posts])

                    <div class="mt-5">
                        {!! $posts->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('posts._sidebar')
        </div>
    </div>

@endsection
