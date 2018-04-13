<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    protected $post;

    public function setUp()
    {
        parent::setUp();
        $this->post = create('App\Post');
    }

    public function testPostHasComments()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->post->comments);
    }

    public function testPostHasAnAuthor()
    {
        $this->assertInstanceOf('App\User', $this->post->author);
    }

    public function testAPostCanAddComment()
    {
        $this->post->addComment([
            'text' => 'some test text',
            'user_id' => 69
        ]);
       $this->assertCount(1, $this->post->comments);
    }

    public function testAPostBelongsToACategory()
    {
       $post = create('App\Post');

       $this->assertInstanceOf('App\Category', $post->category);
    }
}
