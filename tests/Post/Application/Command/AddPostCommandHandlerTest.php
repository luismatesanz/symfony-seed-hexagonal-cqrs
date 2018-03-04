<?php

declare(strict_types = 1);

namespace App\Tests\Post\Application\Command;

use App\Post\Application\Command\AddPostCommand;
use App\Post\Application\Command\AddPostCommandHandler;
use App\Post\Infrastructure\Persistence\InMemory\InMemoryPostRepository;
use PHPUnit\Framework\TestCase;

class AddPostCommandHandlerTest extends TestCase
{
    private $postRepository;
    private $addPostCommandHandler;

    public function setUp()
    {
        $this->setupPostRepository();
        $this->addPostCommandHandler = new AddPostCommandHandler(
            $this->postRepository
        );
    }

    private function setupPostRepository()
    {
        $this->postRepository = new InMemoryPostRepository();
    }

    /**
     * @test
     */
    public function addPost()
    {
        $this->addPostCommandHandler->handle(new AddPostCommand(new \DateTime('2018-02-03'), 'This is a test case.', ''));
        $posts = $this->postRepository->posts;
        $postFirst = current($posts);
        $this->assertTrue(count($posts) > 0);
        $this->assertEquals($postFirst->title(), 'This is a test case.');
    }
}
