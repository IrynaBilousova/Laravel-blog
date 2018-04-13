<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\Postfilters;

class Post extends Model
{
    protected $guarded =[];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('commentCount', function ($builder) {
                $builder->withCount('comments');
        });
    }

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

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function scopeFilter($query, Postfilters $filters)
    {
        return $filters->apply($query);
    }

    public function isFavorited()
    {
        if ($this->favorites()->where(['user_id' => auth()->id()])->exists())
        {
            return true;

        }
    }

    public function favorite()
    {
        if (! $this->isFavorited())
        {
            return $this->favorites()->create(['user_id' => auth()->user()->id,]);

        }
    }
}
