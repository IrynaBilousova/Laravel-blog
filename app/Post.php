<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded =[];

    public function path()
    {
        return "posts/{$this->category->slug}/{$this->id}";
    }
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function addComment($comment)
    {
        $this->comments()->create($comment);
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }
}
