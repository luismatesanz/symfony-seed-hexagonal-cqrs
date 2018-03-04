<?php

declare(strict_types = 1);

namespace App\Tests\Post\Application\Command;

use App\Post\Application\Command\DeletePostCommand;
use App\Post\Application\Command\DeletePostCommandHandler;
use App\Post\Infrastructure\Persistence\InMemory\InMemoryPostRepository;
use App\Tests\Post\Domain\Model\PostDummy;
use PHPUnit\Framework\TestCase;

class DeletePostCommandHandlerTest extends TestCase
{
    private $postRepository;
    private $deletePostCommandHandler;
    private $dummyPost;

    public function setUp()
    {
        $this->setupPostRepository();
        $this->deletePostCommandHandler = new DeletePostCommandHandler(
            $this->postRepository
        );
    }

    private function setupPostRepository()
    {
        $this->postRepository = new InMemoryPostRepository();
        $this->dummyPost = PostDummy::create($this->postRepository->nextIdentity(), '2018-02-03', 'Title Init.', 'Text Init');
        $this->postRepository->add($this->dummyPost);
    }

    /**
     * @test
     */
    public function deletePost()
    {
        $this->deletePostCommandHandler->handle(new DeletePostCommand($this->dummyPost->id()->id()));
        $posts = $this->postRepository->posts;
        $this->assertTrue(count($posts) == 0);
    }
}
