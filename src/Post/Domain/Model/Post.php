<?php

declare(strict_types = 1);

namespace App\Post\Domain\Model;

use App\Kernel\Domain\Event\DomainEventPublisher;
use App\User\Domain\Model\User;
use Doctrine\Common\Collections\ArrayCollection;

class Post
{
    private $postId;
    private $dateCreation;
    private $date;
    private $title;
    private $text;
    private $status;
    private $comments;

    public function __construct(PostId $postId, \DateTime $date, string $title, ?string $text)
    {
        $this->postId = $postId;
        $this->dateCreation = new \DateTime();
        $this->date = $date;
        $this->status = "open";
        $this->title = $title;
        $this->text = $text;
        $this->comments = new ArrayCollection();

        DomainEventPublisher::instance()->publish(new PostWasMade(
            $this->id(),
            $this->title()
        ));
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

    public function changeDate(\DateTime $date) : Post
    {
        $this->date = $date;
        return $this;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function changeTitle(string $title) : Post
    {
        $this->title = $title;
        return $this;
    }

    public function text(): ?string
    {
        return $this->text;
    }

    public function changeText(string $text): Post
    {
        $this->text = $text;
        return $this;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function comments()
    {
        return $this->comments;
    }

    public function calculateStatus() : void
    {
        $this->status = "open";
        $today = new \DateTime();
        if ($this->date() < $today) {
            $this->status = "lapsed";
        }
    }

    public function addComment(User $user, $text)
    {
        $this->comments[] = new PostComment(
            new PostCommentId(),
            $this,
            $user,
            $text
        );
    }

    public function updateComment(PostCommentId $postCommentId, $text)
    {
        foreach ($this->comments as $k => $comment) {
            if ($comment->postCommentId()->equals($postCommentId)) {
                $comment->changeText($text);
                break;
            }
        }
    }

    public function deleteComment(PostCommentId $postCommentId)
    {
        foreach ($this->comments as $k => $comment) {
            if ($comment->postCommentId()->equals($postCommentId)) {
                unset($this->comments[$k]);
                break;
            }
        }
    }
}
