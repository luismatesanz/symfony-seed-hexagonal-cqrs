<?php

declare(strict_types = 1);

namespace App\User\Application\Command;

use App\Kernel\Application\Command\Command;
use App\User\Domain\Model\UserId;

final class UpdateUserCommand implements Command
{
    private $id;
    private $username;
    private $email;
    private $enabled;

    public function __construct(UserId $id, string $username, string $email, bool $enabled)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->enabled = $enabled;
    }

    public function id(): UserId
    {
        return $this->id;
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
