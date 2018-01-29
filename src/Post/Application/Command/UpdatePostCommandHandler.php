<?php


namespace App\Post\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Kernel\Application\Command\CommandHandler;
use App\Post\Domain\Model\PostRepository;

class UpdatePostCommandHandler implements CommandHandler
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handle(Command $command = null)
    {
        $post = $this->postRepository->ofId($command->id());
        $post->changeTitle($command->title());

        return $this->postRepository->update($post);
    }
}