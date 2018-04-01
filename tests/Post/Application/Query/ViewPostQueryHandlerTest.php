<?php

declare(strict_types = 1);

namespace App\Tests\Post\Application\Query;

use App\Post\Application\Query\ViewPostQuery;
use App\Post\Application\Query\ViewPostQueryHandler;
use App\Post\Application\Query\ViewPostResponse;
use App\Post\Infrastructure\Persistence\InMemory\InMemoryPostRepository;
use App\Tests\Post\Domain\Model\PostDummy;
use PHPUnit\Framework\TestCase;

class ViewPostQueryHandlerTest extends TestCase
{
    private $postRepository;
    private $viewPostQueryHandler;
    private $dummyPost;

    public function setUp()
    {
        $this->setupPostRepository();
        $this->viewPostQueryHandler = new ViewPostQueryHandler(
            $this->postRepository
        );
    }

    private function setupPostRepository()
    {
        $this->postRepository = new InMemoryPostRepository();
        $this->dummyPost = PostDummy::create($this->postRepository->nextIdentity(), '2018-02-03', 'This is a test case.', '');
        $this->postRepository->add($this->dummyPost);
    }

    /**
     * @test
     * @expectedException App\Post\Domain\Model\PostDoesNotExistException
     */
    public function throwAnExceptionPostDoesNotExists()
    {
        $this->viewPostQueryHandler->handle(new ViewPostQuery('1'));
    }

    /**
     * @test
     */
    public function getPostExists()
    {
        $post = $this->viewPostQueryHandler->handle(new ViewPostQuery($this->dummyPost->id()->id()));
        $this->assertEquals($post, new ViewPostResponse($this->dummyPost));
    }
}
