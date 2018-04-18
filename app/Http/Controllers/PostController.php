<?php

namespace App\Http\Controllers;

use App\Category;
use App\Filters\Postfilters;
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
    public function index(Category $category,  Postfilters $filters)
    {
        //:TODO вкладка "Browse" как в видео 17
        if($category->exists) {
            $posts = $category->posts()->latest();
        } else {
            $posts = Post::with('category')->latest();
        }

        $posts = $posts->filter($filters)->paginate(10);

        if(request()->wantsJson())
        {
            return $posts;
        }

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
    public function show($category, Post $post)
    {
        $comments = $post->comments()->with('author')->paginate(10);
        return view('posts.show', compact(['post' , 'comments' ]));
    }

    /**
     * Remove the specified post  from storage.
     *
     * @param $category
     * @param Post $post
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy($category, Post $post)
    {
        $this->authorize('update', $post);

        $post->delete();
        if(\request()->wantsJson()){
            return response([], 200);
        }
        return redirect('/posts');
    }
}
