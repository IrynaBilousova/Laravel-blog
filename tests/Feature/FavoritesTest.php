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
}
