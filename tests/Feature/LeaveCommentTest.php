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

    public function testUnathorizedUsersCannotDeleteReplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $comment = create('App\Comment');

        $this->delete("/comments/{$comment->id}")
            ->assertRedirect('login');
    }


    public function testAuthorizedButNotAnAuthorCannotDeleteComments()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        $comment = create('App\Comment');

        $this->signIn()
            ->delete("/comments/{$comment->id}");
    }

    public function testAuthorizedAndAuthorCanDeleteComments()
    {
        $this->signIn();


        $comment = create('App\Comment', [
            'user_id' => auth()->user()->id
        ]);


        $this->delete("/comments/{$comment->id}")->assertStatus(302);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function testAuthorizedAndAuthorCanUpdateComments()
    {
        $this->signIn();


        $comment = create('App\Comment', [
            'user_id' => auth()->user()->id
        ]);


        $this->patch("/comments/{$comment->id}", [ 'text' => 'Changed text.']);
        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'text' => 'Changed text.']);
    }


}
