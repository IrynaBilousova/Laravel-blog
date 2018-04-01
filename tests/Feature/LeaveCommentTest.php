<?php

namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaveCommentTest extends TestCase
{
    public function testAGuestMayNotLeaveComment()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/posts/1' , []);
    }

   public function testAnAuthenticatedUserMayLeaveComment()
    {
        //Given we have a signed in user
        $this->signIn();

        $post = create('App\Post');

        $comment = make('App\Comment');

        $this->post('/posts/' . $post->id . "/", $comment->toArray());

        $this->get('/posts/' . $post->id)->assertSee($comment->text);
    }
}
