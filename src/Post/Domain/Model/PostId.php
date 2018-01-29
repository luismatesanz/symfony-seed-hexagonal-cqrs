<?php

namespace App\Post\Domain\Model;

use Ramsey\Uuid\Uuid;

class PostId
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

    public function equals(PostId $wishId)
    {
        return $this->id() === $wishId->id();
    }

    public function __toString()
    {
        return $this->id();
    }
}