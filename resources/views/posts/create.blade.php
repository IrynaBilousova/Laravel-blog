@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="/posts">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="category_id">Choose a category:</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Choose one...
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                   {{ $category->name }}
                                </option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input id="title" name="title" class="form-control" value="{{old('title')}}" required>
                        </div>
                        <div class="form-group">
                            <textarea rows="5" id="body" name="body" class="form-control" placeholder="Add text here..." value="{{old('body')}}" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>

                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                  <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            @endif

                    </form>

            </div>
        </div>
    </div>
@stop