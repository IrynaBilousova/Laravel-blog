<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Category $category, $postId)
    {
        $post = Post::find($postId);
        $post->favorite();
        return back();
    }
}
