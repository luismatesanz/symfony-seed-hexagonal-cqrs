<?php

declare(strict_types = 1);

namespace App\Post\Application\Command\Aggregate;

use App\Post\Domain\Model\PostCommentId;
use App\User\Domain\Model\UserId;

class PostCommentCommand
{
    private $postCommentId;
    private $userId;
    private $text;

    public function __construct(?string $id, string $userId, string $text)
    {
        $this->postCommentId = ($id) ? new PostCommentId($id): null;
        $this->userId = new UserId($userId);
        $this->text = $text;
    }

    public function postCommentId(): ?PostCommentId
    {
        return $this->postCommentId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function text(): ?string
    {
        return $this->text;
    }
}
