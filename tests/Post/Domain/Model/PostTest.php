<?php


namespace App\Tests\Post\Domain\Model;

use App\Post\Domain\Model\Post;

/*class PostTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculateStatus()
    {
        // CHECK OPEN
        $today = new  \DateTime();
        $post = new Post($today->modify('-10 days'), 'Test 1', '');
        $post->calculateStatus($post);
        $this->assertEquals($post->status(), 'lapsed');
        // CHECK LAPSED
        $today = new  \DateTime();
        $post = new Post($today->modify('+10 days'), 'Test 1', '');
        $post->calculateStatus($post);
        $this->assertEquals($post->status(), 'open');
    }
}*/
