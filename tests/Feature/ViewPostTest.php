<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;

class ViewPostTest extends TestCase
{
    protected $post;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->post = create('App\Post');
    }

    public function testUserCanViewAllBlogPosts()
    {
        $this->get('/posts')->assertSee($this->post->title);
    }

    public function testUserCanViewSingleBlogPost()
    {
        $this->get($this->post->path())->assertSee($this->post->title);
    }

     public function testUserCanViewCommentsAssociatedWithPost()
    {
        $comment = create('App\Comment', [ 'post_id' => $this->post->id]);
        $this->get($this->post->path())->assertSee($comment->text);
    }

    public function testAUserCanFilterPostsAccordingToACategory()
    {
        $category = create('App\Category');
        $postInCategory = create('App\Post', ['category_id' => $category->id]);
        $postNotInCategory = create('App\Post');

        $this->get('/posts/' . $category->slug)
            ->assertSee($postInCategory->title)
            ->assertDontSee($postNotInCategory->title);
    }

    public function testAUserCanFilterPostsByAnyUsername()
    {
        $this->signIn(create('App\User', ['name' => 'IraBilous']));

        $postByIraBilous = create('App\Post', ['user_id' => auth()->id()]);
        $postNotByIraBilous = create('App\Post');

        $this->get('posts?by=IraBilous')
            ->assertSee($postByIraBilous->title)
            ->assertDontSee($postNotByIraBilous->title);
    }
}
