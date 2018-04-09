<?php

declare(strict_types = 1);

namespace App\User\Domain\Model;

use Assert\Assertion;

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
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setEnabled(true);
        $this->setPassword($password);
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

    private function setUsername(string $username): void
    {
        Assertion::notEmpty($username);
        $this->username = $username;
    }

    public function changeUsername(string $username): void
    {
        $this->setUsername($username);
    }

    public function email(): string
    {
        return $this->email;
    }

    private function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function changeEmail(string $email): void
    {
        $this->setEmail($email);
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    private function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function changeEnabled(bool $enabled): void
    {
        $this->setEnabled($enabled);
    }

    public function password() : string
    {
        return $this->password;
    }

    private function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}
