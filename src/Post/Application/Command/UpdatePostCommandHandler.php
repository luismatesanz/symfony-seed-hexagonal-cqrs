<?php

declare(strict_types = 1);

namespace App\Post\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Kernel\Application\Command\CommandHandler;
use App\Post\Application\Command\Aggregate\PostCommentCommand;
use App\Post\Domain\Model\PostCommentId;
use App\Post\Domain\Model\PostDoesNotExistException;
use App\Post\Domain\Model\PostRepository;
use App\User\Domain\Model\UserRepository;

final class UpdatePostCommandHandler implements CommandHandler
{
    private $postRepository;
    private $userRepository;

    public function __construct(PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(Command $command = null)
    {
        $post = $this->postRepository->ofId($command->postId());

        if (!$post) {
            throw new PostDoesNotExistException();
        }

        $post = $post->changeDate($command->date());
        $post = $post->changeTitle($command->title());
        $post = $post->changeText($command->text());
        // MODIFY AGGREGATE COMMENTS
        $this->changeComments($post, $command);

        $this->postRepository->update($post);
    }

    private function changeComments($post, Command $command)
    {
        // SAVE COMMENTS BEFORE UPDATE & INSERT
        $commentsBefore = clone $post->comments();
        // MODIFY COMMENTS
        foreach ($command->comments() as $comment) {
            if ($comment instanceof PostCommentCommand) {
                if ($this->checkExists($comment->postCommentId(), $post->comments()->toArray())) {
                    $post->updateComment($comment->postCommentId(), $comment->text());
                } else {
                    $user = $this->userRepository->ofId($comment->userId());
                    $post->addComment($user, $comment->text());
                }
            }
        }

        // REMOVE COMMENTS NOT EXISTS
        foreach ($commentsBefore as $comment) {
            if (false === $this->checkExists($comment->postCommentId(), $command->comments())) {
                $post->deleteComment($comment->postCommentId());
            }
        }
    }

    private function checkExists(?PostCommentId $postCommentId, array $array): bool
    {
        if ($postCommentId) {
            foreach ($array as $value) {
                if ($value->postCommentId() && $value->postCommentId()->equals($postCommentId)) {
                    return true;
                }
            }
        }
        return false;
    }
}
