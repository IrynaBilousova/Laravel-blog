<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testACategoryConsistsOfPosts()
    {
     $category =  create('App\Category');
     $post = create('App\Post', ['category_id' => $category->id]);

     $this->assertTrue($category->posts->contains($post));
    }
}
