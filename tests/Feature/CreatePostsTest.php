<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostsTest extends TestCase
{
    public function testGuestsMayNotCreatePosts()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get('posts/create');
        $this->assertRedirect('/login');

        $this->post('/posts');
        $this->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserCanCreateNewPost()
    {
        $this->signIn();
        $post = make('App\Post');

        $response = $this->post('/posts', $post->toArray());

        $this->get($response->headers->get('Location'))->assertSee($post->body);
    }

    public function testAPostRequiresATitle()
    {
        $this->publishPost([ 'title' => null])->assertSessionHasErrors('title');
    }

    public function testAPostRequiresABody()
    {
        $this->publishPost([ 'body' => null])->assertSessionHasErrors('body');
    }

    public function testAPostRequiresAValidCategory()
    {
        factory('App\Category', 2)->create();

        $this->publishPost([ 'category_id' => null])->assertSessionHasErrors('category_id');

        $this->publishPost([ 'category_id' => 2000])->assertSessionHasErrors('category_id');
    }

    public function publishPost($overrides = [])
    {
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->signIn();

        $thread = make('App\Post', $overrides);

        return $this->post('/posts', $thread->toArray());
    }
}
