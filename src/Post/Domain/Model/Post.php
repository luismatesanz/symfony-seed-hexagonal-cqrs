<?php

namespace App\Post\Domain\Model;

class Post
{
    private $postId;
    private $dateCreation;
    private $date;
    private $title;
    private $text;
    private $status;

    public function __construct(PostId $postId, \DateTime $date, string $title, ?string $text)
    {
        $this->postId = $postId;
        $this->dateCreation = new \DateTime();
        $this->date = $date;
        $this->status = "open";
        $this->title = $title;
        $this->text = $text;
    }

    public function id()
    {
        return $this->postId;
    }

    public function dateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    public function date(): \DateTime
    {
        return $this->date;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function changeTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function text(): ?string
    {
        return $this->text;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function calculateStatus() : void
    {
        $this->status = "open";
        $today = new \DateTime();
        if ($this->date() < $today){
            $this->status = "lapsed";
        }
    }
}