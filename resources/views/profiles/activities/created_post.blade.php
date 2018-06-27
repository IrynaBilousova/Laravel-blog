<div class="card">
    <div class="card-header">
        @php
            //:TODO заменить маршрут на $post->path(). При замене некорректно переходит со страницы какой-либо категории на просмотр поста
        @endphp
        <h1>
            <a class="title" href="{{route('show_post', ['category' =>$post->category->slug, 'id' => $post->id])}}">{{$post->title}}</a>
        </h1>
        <p>has {{$post->comments_count}} {{str_plural('comment',$post->comments_count )}}</p>
    </div>

    <div class="card-body">
        <p>
            {{$post->body}}
        </p>
    </div>
</div>