<?php

declare(strict_types = 1);

namespace App\Tests\Post\Application\Query;

use App\Post\Application\Query\ViewPostsQuery;
use App\Post\Application\Query\ViewPostsQueryHandler;
use App\Post\Application\Query\ViewPostsResponse;
use App\Tests\Post\Domain\Model\PostDummy;
use App\Post\Infrastructure\Persistence\InMemory\InMemoryPostRepository;
use PHPUnit\Framework\TestCase;

class ViewPostsQueryHandlerTest extends TestCase
{
    private $postRepository;
    private $viewPostsQueryHandler;
    private $dummyPost;
    private $dummyPost2;

    public function setUp()
    {
        $this->setupPostRepository();
        $this->viewPostsQueryHandler = new ViewPostsQueryHandler(
            $this->postRepository
        );
    }

    private function setupPostRepository()
    {
        $this->postRepository = new InMemoryPostRepository();
        $this->dummyPost = PostDummy::create($this->postRepository->nextIdentity(), '2018-02-03', 'This is a test case.', '');
        $this->dummyPost2 = PostDummy::create($this->postRepository->nextIdentity(), '2018-01-05', 'This is a test case 2.', '');
        $this->postRepository->add($this->dummyPost);
        $this->postRepository->add($this->dummyPost2);
    }

    /**
     * @test
     */
    public function getAllPostExists()
    {
        $post = $this->viewPostsQueryHandler->execute(new ViewPostsQuery());
        $this->assertEquals(
            $post,
            new ViewPostsResponse(
                array(
                    $this->dummyPost->id()->id() => $this->dummyPost,
                    $this->dummyPost2->id()->id() => $this->dummyPost2
                )
            )
        );
    }
}
