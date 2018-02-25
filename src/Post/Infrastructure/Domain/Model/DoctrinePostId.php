<?php

declare(strict_types = 1);

namespace App\Post\Infrastructure\Domain\Model;

use App\Kernel\Infrastructure\Domain\Model\DoctrineEntityId;

class DoctrinePostId extends DoctrineEntityId
{
    public function getName()
    {
        return 'PostId';
    }
    protected function getNamespace()
    {
        return 'App\Post\Domain\Model';
    }
}
