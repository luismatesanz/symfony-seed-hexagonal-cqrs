<?php

declare(strict_types = 1);

namespace App\User\Application\Command;

use App\Kernel\Application\Command\Command;
use App\User\Domain\Model\UserId;

final class UpdateUserCommand implements Command
{
    private $userId;
    private $username;
    private $email;
    private $enabled;

    public function __construct(string $id, string $username, string $email, bool $enabled)
    {
        $this->userId = new UserId($id);
        $this->username = $username;
        $this->email = $email;
        $this->enabled = $enabled;
    }

    public function userId(): UserId
    {
        return $this->userId;
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
