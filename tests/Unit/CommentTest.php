<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCommentHasAnAuthor()
    {
        $comment = factory('App\Comment')->create(['post_id' => 1 ]);
        $this->assertInstanceOf('App\User', $comment->author);
    }
}
