<?php

declare(strict_types = 1);

namespace App\Post\Application\Query;

use App\Post\Application\Query\Aggregate\ViewPostCommentResponse;
use App\Post\Domain\Model\Post;

final class ViewPostResponse
{
    private $id;
    private $date;
    private $title;
    private $text;
    private $comments;

    public function __construct(Post $post)
    {
        $this->id = $post->id()->id();
        $this->date = $post->date();
        $this->title = $post->title();
        $this->text = $post->text();
        foreach ($post->comments() as $key => $comment) {
            $this->comments[$key] = new ViewPostCommentResponse($comment);
        }
    }

    public function id(): string
    {
        return $this->id;
    }

    public function date(): \DateTime
    {
        return $this->date;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function comments() : ?array
    {
        return $this->comments;
    }
}
