<?php

declare(strict_types = 1);

namespace App\User\Application\Query;

use App\Kernel\Application\Query\Query;
use App\User\Domain\Model\UserId;

final class ViewUserQuery implements Query
{
    private $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function userId() : UserId
    {
        return $this->userId;
    }
}
