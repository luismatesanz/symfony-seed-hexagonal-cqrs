<?php

declare(strict_types = 1);

namespace App\Post\Domain\Model;

use Ramsey\Uuid\Uuid;

final class PostCommentId
{
    private $id;

    public function __construct($id = null)
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
    }

    public function id()
    {
        return $this->id;
    }

    public function equals(PostCommentId $wishId)
    {
        return $this->id() === $wishId->id();
    }

    public function __toString()
    {
        return $this->id();
    }
}
