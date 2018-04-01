@extends('layouts.app')

    @section('content')
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @foreach($posts as $post)
                    <div class="card">
                        <div class="card-header">
                            <h1>
                                <a class="title" href="{{url("/posts/{$post->id}")}}">{{$post->title}}</a>
                            </h1>
                        </div>

                        <div class="card-body">
                            <p>
                                {{$post->body}}
                            </p>
                        </div>
                    </div>
                    @endforeach
                    {{  $posts->links() }}

                </div>
            </div>
        </div>
 @stop