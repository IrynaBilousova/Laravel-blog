@extends('layouts.app')

@section('content')

    @php

    @endphp
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>
                    {{$post->title}}
                </h1>
                <p>
                    {{$post->body}}
                </p>
                <p>Written by  <a href="#"> {{$post->author->name}}</a> </p>
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
                    </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                @if(auth()->check())
                        <form method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea rows="5" id="text" name="text" class="form-control" placeholder="Add comment..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Add comment</button>
                        </form>
                    @else
                    <p>Please <a href="{{route('login')}}">sign in</a> to add comment</p>
                @endif
            </div>
        </div>
    </div>
@stop