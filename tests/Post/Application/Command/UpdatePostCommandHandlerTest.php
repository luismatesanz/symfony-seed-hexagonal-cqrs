<?php

declare(strict_types = 1);

namespace App\Tests\Post\Application\Command;

use App\Post\Application\Command\Aggregate\PostCommentCommand;
use App\Post\Application\Command\UpdatePostCommand;
use App\Post\Application\Command\UpdatePostCommandHandler;
use App\Post\Infrastructure\Persistence\InMemory\InMemoryPostRepository;
use App\Tests\Post\Domain\Model\PostDummy;
use App\Tests\User\Domain\Model\UserDummy;
use App\User\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;

class UpdatePostCommandHandlerTest extends TestCase
{
    private $postRepository;
    private $userRepository;
    private $updatePostCommandHandler;
    private $dummyPost;
    private $dummyUser;

    public function setUp()
    {
        $this->setupPostRepository();
        $this->setupUserRepository();
        $this->updatePostCommandHandler = new UpdatePostCommandHandler(
            $this->postRepository,
            $this->userRepository
        );
    }

    private function setupPostRepository()
    {
        $this->postRepository = new InMemoryPostRepository();
        $this->dummyPost = PostDummy::create($this->postRepository->nextIdentity(), '2018-02-03', 'Title Init.', 'Text Init');
        $this->postRepository->add($this->dummyPost);
    }

    private function setupUserRepository()
    {
        $this->userRepository = new InMemoryUserRepository();
        $this->dummyUser = UserDummy::create($this->userRepository->nextIdentity(), 'username', 'password', 'info@email.com');
        $this->userRepository->add($this->dummyUser);
    }

    /**
     * @test
     */
    public function dataPostShouldBeModified()
    {
        $postId = $this->dummyPost->id();
        $dateNew = new \DateTime('2018-02-18');
        $titleNew = 'New Title';
        $textNew = 'New Text';
        $this->updatePostCommandHandler->handle(new UpdatePostCommand(
            $postId->id(),
            $dateNew,
            $titleNew,
            $textNew,
            $this->dummyPost->comments()->toArray()
        ));
        $post = $this->postRepository->ofId($postId);
        $this->assertEquals($dateNew, $post->date());
        $this->assertEquals($titleNew, $post->title());
        $this->assertEquals($textNew, $post->text());
    }

    /*
     * @test
     *
    public function dataPostCommentAggregateShouldBeModified()
    {
        $commentDummy1 = new PostCommentCommand(
            null,
            $this->dummyUser->id()->id(),
            'Comment Dummy 1'
            );
        $commentDummy2 = new PostCommentCommand(
            null,
            $this->dummyUser->id()->id(),
            'Comment Dummy 2'
            );
        $comments = array($commentDummy1, $commentDummy2);
        $postId = $this->dummyPost->id();
        $this->updatePostCommandHandler->handle(new UpdatePostCommand(
            $postId->id(),
            $this->dummyPost->date(),
            $this->dummyPost->title(),
            $this->dummyPost->text(),
            $comments
        ));
        $post = $this->postRepository->ofId($postId);
        //$text = array_column($post->comments(), 'text');
        //die($text);
    }*/
}
