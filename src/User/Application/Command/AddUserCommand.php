<?php

declare(strict_types = 1);

namespace App\User\Application\Command;

use App\Kernel\Application\Command\Command;

final class AddUserCommand implements Command
{
    private $username;
    private $email;
    private $password;

    public function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
