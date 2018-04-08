<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use App\Post;
use App\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        if($category->exists) {
            $posts = $category->posts()->latest();
        } else {
            $posts = Post::latest();
        }

        if($username = request('by'))
        {
            $user = User::where('name', $username)->firstOrFail();
            $posts->where('user_id', $user->id);
        }
        $posts=$posts->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //:TODO Почему автоматически id не записывалось?
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        $attr = $request->all();
        $attr['user_id'] = auth()->id();
        $post = Post::create($attr);
        return redirect($post->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId, $id)
    {
        $post = Post::with('category')->find($id);
        $comments = Comment::where('post_id', $id)->with('author')->get();
        return view('posts.show', compact(['post' , 'comments', ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
