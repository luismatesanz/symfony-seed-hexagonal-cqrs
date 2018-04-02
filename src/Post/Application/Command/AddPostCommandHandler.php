<?php

declare(strict_types = 1);

namespace App\Post\Application\Command;

use App\Kernel\Application\Command\CommandHandler;
use App\Post\Application\Query\ViewPostResponse;
use App\Post\Domain\Model\Post;
use App\Post\Domain\Model\PostRepository;

final class AddPostCommandHandler implements CommandHandler
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handle(AddPostCommand $command = null) : ViewPostResponse
    {
        $post = new Post($this->postRepository->nextIdentity(), $command->date(), $command->title(), $command->text());
        $this->postRepository->add($post);


        return new ViewPostResponse($post);
    }
}
