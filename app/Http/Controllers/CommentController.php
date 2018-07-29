<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' =>  'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category, Post $post)
    {
        return $post->comments()->paginate(1);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($category, Post $post, Request $request)
    {
        $request->validate([
            'text' => 'required'
        ]);

        $comment = $post->addComment([
           'text' => $request->input('text'),
            'user_id' => auth()->id(),
        ]);

        if (request()->expectsJson()) {
            return $comment->load('author');
        }
        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update(['text' => $request['text']]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Comment deleted.']);
        }

        return back();
    }
}
