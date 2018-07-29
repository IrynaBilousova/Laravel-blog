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
        parent::setUp();
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
        $this->signIn(create('App\User', ['name' => 'Ira']));

        $postByIra = create('App\Post', ['user_id' => auth()->id()]);
        $postNotByIra = create('App\Post');

        $this->get('posts?by=Ira')
            ->assertSee($postByIra->title)
            ->assertDontSee($postNotByIra->title);
    }

    public function testAUserCanFilterPostsByPopularity()
    {

        $postWithSixComments = create('App\Post');
        create('App\Comment',['post_id' => $postWithSixComments->id] ,6);

        $postWithFiveComments = create('App\Post');
        create('App\Comment', ['post_id' => $postWithFiveComments->id] ,5);
        //:TODO вот тут отсебятина, норм ли?
        $response = $this->getJson('posts?popular=1')->json();
        $response = array_column($response['data'], 'comments_count');

        $sortedResponse = $response;

        array_multisort($sortedResponse, SORT_DESC);

        $this->assertEquals($sortedResponse, $response);


    }

    public function testAUserCanRequestAllCommentsForAGivenPost()
    {
        $post = create('App\Post');
        create('App\Comment', ['post_id' => $post->id], 2);
        $response = $this->getJson($post->path() . '/comments')->json();

        $this->assertCount(1, $response['data']);
        $this->assertEquals(2, $response['total']);
    }
}
