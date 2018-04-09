<?php

declare(strict_types = 1);

namespace App\Post\Domain\Model;

use App\User\Domain\Model\User;

final class PostComment
{
    private $postCommentId;
    private $post;
    private $user;
    private $dateCreation;
    private $text;

    public function __construct(PostCommentId $postCommentId, Post $post, User $user, string $text)
    {
        $this->postCommentId = $postCommentId;
        $this->post = $post;
        $this->user = $user;
        $this->dateCreation = new \DateTime();
        $this->setText($text);
    }

    public function postCommentId(): PostCommentId
    {
        return $this->postCommentId;
    }

    public function post(): Post
    {
        return $this->post;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function dateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    public function text(): string
    {
        return $this->text;
    }

    private function setText(string $text): void
    {
        $this->text = $text;
    }

    public function changeText(string $text): void
    {
        $this->setText($text);
    }
}
