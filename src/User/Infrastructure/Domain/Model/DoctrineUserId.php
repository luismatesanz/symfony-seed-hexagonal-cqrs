<?php

declare(strict_types = 1);

namespace App\User\Infrastructure\Domain\Model;

use App\Kernel\Infrastructure\Domain\Model\DoctrineEntityId;

final class DoctrineUserId extends DoctrineEntityId
{
    public function getName()
    {
        return 'UserId';
    }
    protected function getNamespace()
    {
        return 'App\User\Domain\Model';
    }
}
