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
        $post = create('App\Post');
        $this->post(route('show_post', ['category' =>$post->category->slug, 'id' => $post->id]) , []);
    }

   public function testAnAuthenticatedUserMayLeaveComment()
    {
        $this->signIn();

        $post = create('App\Post');

        $comment = make('App\Comment');

        $this->post($post->path() , $comment->toArray());

        $this->get( $post->path())->assertSee($comment->text);
    }

    public function testACommentRequiresAText()
    {
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->signIn();
        $post = create('App\Post');

        $comment = make('App\Comment', ['text' => null]);

        $this->post($post->path() , $comment->toArray())->assertSessionHasErrors('text');
    }
}
