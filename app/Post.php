<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\Postfilters;

class Post extends Model
{
    use Favoritable;

    /**
     * Don't auto apply mass assignment protection
     *
     * @var array
     */
    protected $guarded =[];

    /**
     * Boots the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('commentCount', function ($builder) {
                $builder->withCount('comments');
        });

        static::deleting(function($post){
            $post->comments()->delete();
        });
    }

    /**
     * Get a string path to a Post.
     *
     * @return string
     */
    public function path()
    {
        return "posts/{$this->category->slug}/{$this->id}";
    }

    /**
     * A post has an author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * A post has comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Adds a comment to the current post.
     *
     * @param $comment
     */
    public function addComment($comment)
    {
        $this->comments()->create($comment);
    }

    /**
     * A post belongs to category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    /**
     *Filters the current post according to applied filters.
     *
     * @param $query
     * @param Postfilters $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, Postfilters $filters)
    {
        return $filters->apply($query);
    }

}
