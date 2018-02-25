<?php

declare(strict_types = 1);

namespace App\Post\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Kernel\Application\Command\CommandHandler;
use App\Post\Domain\Model\Post;
use App\Post\Domain\Model\PostRepository;

class AddPostCommandHandler implements CommandHandler
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handle(Command $command = null)
    {
        $this->postRepository->add(
            new Post($this->postRepository->nextIdentity(), $command->date(), $command->title(), $command->text())
        );
    }
}
