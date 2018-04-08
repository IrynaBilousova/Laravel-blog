<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   public function getRouteKeyName()
   {
       return 'slug'; // TODO: Change the autogenerated stub
   }

   public function posts()
   {
       return $this->hasMany('App\Post');
   }
}
