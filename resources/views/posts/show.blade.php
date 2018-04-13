@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>
                    {{$post->title}}
                </h1>
                <p>
                    {{$post->body}}
                </p>
                <div class="row justify-content-end">
                    <form action="{{"/posts/{$post->category->slug}/{$post->id}/favorites"}}" method="POST">
                        {{csrf_field()}}
                        <button class="btn btn-default" {{$post->isFavorited() ? 'disabled' : ''}}>
                            {{ str_plural('Favorite', $post->favorites()->count()) . ' ' . $post->favorites()->count()}}
                        </button>
                    </form>
                </div>
                <p>Written by  <a href="#"> {{$post->author->name}}</a><br> posted {{$post->created_at->diffForHumans()}} </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <h3>Comments ({{count($comments)}})</h3>
                <p>
                @foreach($comments as $comment)
                    <hr>
                    <a href="#">{{$comment->author->name}}</a>
                    <br>
                    {{$comment->text}}
                    <br>
                    {{$comment->created_at->diffForHumans()}}
                    @endforeach
                    {{$comments->links()}}
                    </p>
                @if(auth()->check())
                        <form method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea rows="5" id="text" name="text" class="form-control" placeholder="Add comment..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add comment</button>
                        </form>
                    @else
                    <p>Please <a href="{{route('login')}}">sign in</a> to add comment</p>
                @endif
            </div>
        </div>
    </div>
@stop