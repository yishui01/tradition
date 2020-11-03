@if (count($posts))
    <ul class="list-unstyled">
        @foreach ($posts as $post)
            <li class="media">
                <div class="media-left">
                    <a href="{{ route('users.show', [$post->user_id]) }}">
                        <img class="media-object img-thumbnail mr-3" style="width: 52px; height: 52px;"
                             src="{{ $post->user->avatar }}" title="{{ $post->user->name }}">
                    </a>
                </div>
                <div class="media-body">

                    <div class="media-heading mt-0 mb-1">
                        <a href="{{ $post->link() }}" title="{{ $post->title }}">
                            {{ $post->title }}
                        </a>
                        <a class="float-right" href="{{ $post->link() }}">
                            <span class="badge badge-secondary badge-pill"> {{ $post->reply_count }} </span>
                        </a>
                    </div>

                    <small class="media-body meta text-secondary">

                        <a class="text-secondary" href="{{ route('categories.show', $post->category_id) }}"
                           title="{{ $post->category->title }}">
                            <i class="far fa-folder"></i>
                            {{ $post->category->title }}
                        </a>

                        <span> • </span>
                        <a class="text-secondary" href="{{ route('users.show', [$post->user_id]) }}"
                           title="{{ $post->user->name }}">
                            <i class="far fa-user"></i>
                            {{ $post->user->name }}
                        </a>
                        <span> • </span>
                        <i class="far fa-clock"></i>
                        <span class="timeago"
                              title="最后活跃于：{{ $post->updated_at }}">{{ $post->updated_at->diffForHumans() }}</span>
                    </small>

                </div>
            </li>

            @if ( ! $loop->last)
                <hr>
            @endif

        @endforeach
    </ul>

@else
    <div class="empty-block">暂无数据 ~_~</div>
@endif
