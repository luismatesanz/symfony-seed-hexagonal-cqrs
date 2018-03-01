<?php

declare(strict_types = 1);

namespace App\Post\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Post\Domain\Model\PostId;
use Doctrine\Common\Collections\ArrayCollection;

final class UpdatePostCommand implements Command
{
    private $postId;
    private $date;
    private $title;
    private $text;
    private $comments;

    public function __construct(string $id, ?\DateTime $date, ?string $title, ?string $text, ?ArrayCollection $comments)
    {
        $this->postId = new PostId($id);
        $this->date = $date;
        $this->title = $title;
        $this->text = $text;
        $this->comments = $comments;
    }

    public function postId(): PostId
    {
        return $this->postId;
    }

    public function date(): ?\DateTime
    {
        return $this->date;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function text(): ?string
    {
        return $this->text;
    }

    public function comments(): ?ArrayCollection
    {
        return $this->comments;
    }
}
