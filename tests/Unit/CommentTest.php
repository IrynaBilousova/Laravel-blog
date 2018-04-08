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
        $comment = create('App\Comment',['post_id' => 1 ]);
        $this->assertInstanceOf('App\User', $comment->author);
    }
}
