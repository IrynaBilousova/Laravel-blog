<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    public function testAUserHasAProfile()
    {
        $user = create('App\User');
        $this->get("profiles/{$user->name}")
            ->assertSee($user->name);
    }

    public function testAProfileDisplaysAllPostsCreatedByAUser()
    {
        $user = create('App\User');

        $post = create('App\Post', ['user_id' => $user->id]);

        $this->get("profiles/{$user->name}")
            ->assertSee($post->title)
            ->assertSee($post->body);
    }
}
