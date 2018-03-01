<?php

declare(strict_types = 1);

namespace App\User\Domain\Model;

use Ramsey\Uuid\Uuid;

final class UserId
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

    public function equals(UserId $wishId)
    {
        return $this->id() === $wishId->id();
    }

    public function __toString()
    {
        return $this->id();
    }
}
