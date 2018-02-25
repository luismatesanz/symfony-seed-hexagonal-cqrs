<?php

declare(strict_types = 1);

namespace App\Post\Application\Query;

use App\Post\Domain\Model\Post;
use App\Post\Domain\Model\PostId;

class ViewPostResponse
{
    private $postId;
    private $date;
    private $title;
    private $text;

    public function __construct(Post $post)
    {
        $this->postId = $post->id()->id();
        $this->date = $post->date();
        $this->title = $post->title();
        $this->text = $post->text();
    }

    public function postId(): string
    {
        return $this->postId;
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
}
