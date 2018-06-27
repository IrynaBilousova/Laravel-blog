@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 offset-2  ">
            <h1>{{$profileUser->name}} </h1>
            <br>since  {{ $profileUser->created_at->diffForHumans() }}
            <hr>
            @forelse($activities as $activity)
                @include("profiles.activities.{$activity->type}")
            @empty
                <p>There is no activity for this user yet.</p>
            @endforelse
            {{ $activities->links() }}
        </div>
    </div>
@stop