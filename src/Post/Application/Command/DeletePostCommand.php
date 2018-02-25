<?php

declare(strict_types = 1);

namespace App\Post\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Post\Domain\Model\PostId;

final class DeletePostCommand implements Command
{
    private $id;

    public function __construct(PostId $id)
    {
        $this->id = $id;
    }

    public function id() : PostId
    {
        return $this->id;
    }
}
