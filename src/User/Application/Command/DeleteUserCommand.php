<?php

declare(strict_types = 1);

namespace App\User\Application\Command;

use App\Kernel\Application\Command\Command;
use App\User\Domain\Model\UserId;

final class DeleteUserCommand implements Command
{
    private $userId;

    public function __construct($id)
    {
        $this->userId = new UserId($id);
    }

    public function userId() : UserId
    {
        return $this->userId;
    }
}
