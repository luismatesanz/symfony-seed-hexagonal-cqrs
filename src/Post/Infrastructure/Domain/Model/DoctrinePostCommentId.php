<?php

declare(strict_types = 1);

namespace App\Post\Infrastructure\Domain\Model;

use App\Kernel\Infrastructure\Domain\Model\DoctrineEntityId;

final class DoctrinePostCommentId extends DoctrineEntityId
{
    public function getName()
    {
        return 'PostCommentId';
    }
    protected function getNamespace()
    {
        return 'App\Post\Domain\Model';
    }
}
