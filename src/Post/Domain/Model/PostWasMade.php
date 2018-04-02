<?php


namespace App\Post\Domain\Model;

use App\Kernel\Domain\Event\DomainEvent;

class PostWasMade implements DomainEvent
{
    const NAME = 'post.post_was_made';

    private $postId;
    private $title;
    private $occurredOn;

    public function __construct(PostId $postId, string $title)
    {
        $this->postId = $postId;
        $this->title = $title;
        $this->occurredOn = new \DateTime();
    }

    public function postId(): PostId
    {
        return $this->postId;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function occurredOn() : \DateTime
    {
        return $this->occurredOn;
    }
}
