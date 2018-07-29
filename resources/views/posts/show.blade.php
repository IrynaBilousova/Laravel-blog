@extends('layouts.app')

@section('content')
    <div id="app">
        <post-view :initial-comments-count="{{ $post->comments_count }}" inline-template>
            <div class="content">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h1>
                            {{$post->title}}
                        </h1>
                        <p>
                            {{$post->body}}
                        </p>
                        @if(Auth::check())
                            <div class="row justify-content-end">
                                <favorite :post="{{ $post }}"></favorite>
                            </div>
                        @endif
                        <p>Written by  <a href="{{  route('profile', $post->author->name) }}"> {{$post->author->name}}</a><br> posted {{$post->created_at->diffForHumans()}} </p>
                        @can('update', $post)
                            <form action="{{url($post->path())}}" method="Post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-link">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 ">
                        <h3>Comments (<span v-text="commentsCount"></span>):</h3>
                        <p>

                            <comments :data="{{ $post->comments }}"
                                      @removed="commentsCount--"
                                      @added="commentsCount++"></comments>
                        </p>

                    </div>
                </div>
            </div>
        </post-view>
    </div>
@stop