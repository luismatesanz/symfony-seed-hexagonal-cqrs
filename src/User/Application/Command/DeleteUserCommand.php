<?php

declare(strict_types = 1);

namespace App\User\Application\Command;

use App\Kernel\Application\Command\Command;
use App\User\Domain\Model\UserId;

final class DeleteUserCommand implements Command
{
    private $id;

    public function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public function id() : UserId
    {
        return $this->id;
    }
}
