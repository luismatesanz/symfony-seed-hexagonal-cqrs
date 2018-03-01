<?php

declare(strict_types = 1);

namespace App\User\Domain\Model;

class User
{
    private $userId;
    private $dateCreation;
    private $username;
    private $email;
    private $enabled;
    private $password;

    public function __construct(UserId $userId, string $username, string $email, string $password)
    {
        $this->userId = $userId;
        $this->dateCreation = new \DateTime();
        $this->username = $username;
        $this->email = $email;
        $this->enabled = true;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function id(): UserId
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

    public function changeUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function changeEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function changeEnabled(bool $enabled): User
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function password()
    {
        return $this->password;
    }
}
