<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class FavoritesTest
 * @package Tests\Feature
 */
class FavoritesTest extends TestCase
{

   public function testAnAuthenticatedUserCanFavoriteAnyPost()
    {
        $this->signIn();

        $post = create('App\Post');

        $this->post($post->path() . '/favorites');

        $this->assertCount(1, $post->favorites);
    }


    public function testAGuestMayNotFavoriteAnyPost()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $post = create('App\Post');

        $this->post($post->path() . '/favorites')->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserMayOnlyFavoriteAPostOnce()
    {
        $this->signIn();

        $post = create('App\Post');

            $this->post($post->path() . '/favorites');
            $this->post($post->path() . '/favorites');

        $this->assertCount(1, $post->favorites);
    }

    /*
    public function testAnAuthenticatedUserCanFavoriteAnyComment()
    {
        $this->signIn();

        $post = create('App\Post');

        $comment = create('App\Comment', [ 'post_id' => $post->id]);

        $this->post($post->path() . $comment->id . '/favorites');

        $this->assertCount(1, $comment->favorites);
    }


    public function testAGuestMayNotFavoriteAnyComment()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $post = create('App\Post');

        $comment = create('App\Comment', [ 'post_id' => $post->id]);

        $this->post($post->path() . $comment->id . '/favorites')->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserMayOnlyFavoriteACommentOnce()
    {
        $this->signIn();

        $post = create('App\Post');

        $comment = create('App\Comment', [ 'post_id' => $post->id]);

        $this->post($post->path() . $comment->id . '/favorites');
        $this->post($post->path() . $comment->id . '/favorites');

        $this->assertCount(1, $comment->favorites);
    }
    */
}
