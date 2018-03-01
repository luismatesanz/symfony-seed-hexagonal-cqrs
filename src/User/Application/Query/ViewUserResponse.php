<?php

declare(strict_types = 1);

namespace App\User\Application\Query;

use App\User\Domain\Model\User;

final class ViewUserResponse
{
    private $userId;
    private $dateCreation;
    private $username;
    private $email;
    private $enabled;

    public function __construct(User $user)
    {
        $this->userId = $user->id()->id();
        $this->dateCreation = $user->dateCreation();
        $this->username = $user->username();
        $this->email = $user->email();
        $this->enabled = $user->enabled();
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function dateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }
}
