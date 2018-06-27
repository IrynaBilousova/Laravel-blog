<?php
/**
 * Created by PhpStorm.
 * User: Ira
 * Date: 15.04.2018
 * Time: 12:44
 */

namespace App;


trait Favoritable
{

    protected static function bootFavoritable()
    {
        static::deleting(function ($model){
           $model->favorites->each->delete();
        });
    }
    /**
     * A Post can be favorited.
     *
     * @return mixed
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Determine if the current post has been favorited.
     *
     * @return bool
     */
    public function isFavorited()
    {
        if ($this->favorites()->where(['user_id' => auth()->id()])->exists()) {
            return true;

        }
    }

    /**
     * Favorite the current post.
     *
     * @return mixed
     */
    public function favorite()
    {
        if (!$this->isFavorited()) {
            return $this->favorites()->create(['user_id' => auth()->user()->id]);

        }
    }

    /**
     * UnFavorite the current post.
     *
     * @return mixed
     */
    public function unFavorite()
    {
            $attributes = ['user_id' => auth()->id()];
            return $this->favorites()->where($attributes)->get()->each->delete();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
}