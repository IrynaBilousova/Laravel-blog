@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 offset-2  ">
            <h1>{{$profileUser->name}} </h1>
            <br>since  {{ $profileUser->created_at->diffForHumans() }}
            <hr>
            @forelse($posts as $post)
                <div class="card">
                    <div class="card-header">
                        <h2>{{$post->title}}</h2>
                    </div>
                    <div class="card-body">
                        <p>{{$post->body}}</p>
                    </div>
                </div>
            @empty
                <p>There is no posts for this user yet.</p>
            @endforelse
            {{ $posts->links() }}
        </div>
    </div>
@stop