<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Activity;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
   /* public function testItRecordsActivityWhenAPostIsCreated()
    {
        $this->signIn();

        $post = create('App\Post');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_post',
            'user_id' => auth()->id(),
            'subject_type' => 'App\Post',
            'subject_id' => $post->id
        ]);

        $activity = Activity::latest()->first();

        $this->assertEquals($activity->subject->id, $post->id);
    }
*/
    public function testItRecordsActivityWhenACommentIsCreated()
    {
        $this->signIn();

        $comment = create('App\Comment');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_comment',
            'user_id' => auth()->id(),
            'subject_type' => 'App\Comment',
            'subject_id' => $comment->id
        ]);

        $activity = Activity::orderBy('id', 'desc')->first();

        $this->assertEquals($activity->subject->id, $comment->id);
    }
}
