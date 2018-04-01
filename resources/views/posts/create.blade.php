@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">

                    <form method="POST" action="/posts">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input id="title" name="title" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <textarea rows="5" id="body" name="body" class="form-control" placeholder="Add text here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Publish</button>
                    </form>

            </div>
        </div>
    </div>
@stop