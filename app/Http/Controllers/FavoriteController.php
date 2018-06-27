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

    public function store(Category $category, Post $post)
    {
        $post->favorite();
        return back();
    }

    public function destroy(Category $category, Post $post)
    {
        $post->unFavorite();
    }
}
