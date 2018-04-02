<?php

declare(strict_types = 1);

namespace App\Post\Application\Command;

use App\Kernel\Application\Command\CommandHandler;
use App\Kernel\Domain\Event\DomainEventDispatcher;
use App\Post\Application\Query\ViewPostResponse;
use App\Post\Domain\Model\Post;
use App\Post\Domain\Model\PostRepository;

final class AddPostCommandHandler implements CommandHandler
{
    private $postRepository;
    private $domainEventDispatcher;

    public function __construct(PostRepository $postRepository, DomainEventDispatcher $domainEventDispatcher)
    {
        $this->postRepository = $postRepository;
        $this->domainEventDispatcher = $domainEventDispatcher;
    }

    public function handle(AddPostCommand $command = null) : ViewPostResponse
    {
        $post = new Post($this->postRepository->nextIdentity(), $command->date(), $command->title(), $command->text());
        $this->postRepository->add($post);

        $events = $post->getEvents();
        $this->domainEventDispatcher->notify($events);

        return new ViewPostResponse($post);
    }
}
