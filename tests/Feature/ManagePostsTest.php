<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagePostsTest extends TestCase
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

        $post = make('App\Post', $overrides);

        return $this->post('/posts', $post->toArray());
    }

    public function testGuestsAndNotAuthorsMayNotDeletePosts()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $post = create('App\Post');

        $this->json('DELETE', $post->path());

        $this->assertRedirect('/login');

        $this->signIn();

        $this->delete($post->path())
        ->assertStatusCode(403);

    }

    public function testAPostCanBeDeletedByItsAuthor()
    {
        $user = create('App\User');

        $this->signIn($user);

        $post = create('App\Post', ['user_id' => $user->id]);

        $comment = create('App\Comment', ['post_id' => $post->id]);

        $response = $this->json('DELETE', $post->path());

        $response->assertStatus(200);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);

    }
}
