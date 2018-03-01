<?php

declare(strict_types = 1);

namespace App\Post\Application\Query\Aggregate;


use App\Post\Domain\Model\PostComment;
use App\User\Application\Query\ViewUserResponse;

final class ViewPostCommentResponse
{
    private $id;
    private $user;
    private $dateCreation;
    private $text;

    public function __construct(PostComment $postComment)
    {
        $this->id = $postComment->postCommentId()->id();
        $this->user = new ViewUserResponse($postComment->user());
        $this->dateCreation = $postComment->dateCreation();
        $this->text = $postComment->text();
    }
}