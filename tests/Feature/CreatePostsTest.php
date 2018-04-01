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
        $post = make('App\Post');
        $this->post('/posts', $post->toArray());
    }

    public function testAnAuthenticatedUserCanCreateNewPost()
    {
        $this->signIn();
        $post = make('App\Post');
        $this->post('/posts', $post->toArray());
        $this->get('posts/' . $post->id)->assertSee($post->body);
    }
}
