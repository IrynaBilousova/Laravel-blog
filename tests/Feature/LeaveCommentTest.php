<?php

namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaveCommentTest extends TestCase
{
    public function testAnUnauthenticatedUserMayNotLeaveComment() //:TODO не работает тест, похоже на ошибку в фабрике
    {

        $this->expectException('Illuminate\Auth\AuthenticationException');


        $this->post('/posts/1' , []);


    }

   public function testAnAuthenticatedUserMayLeaveComment() //:TODO не работает тест, похоже на ошибку в фабрике
    {

        $this->be($user = factory('App\User')->create());

        $post = factory('App\Post')->create();

        $comment = factory('App\Comment')->make();

        $this->post('/posts/' . $post->id . "/", $comment->toArray());

        $this->get('/posts/' . $post->id)->assertSee($comment->text);
    }
}
