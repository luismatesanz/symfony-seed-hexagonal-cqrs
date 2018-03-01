<?php

declare(strict_types = 1);

namespace App\Post\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Post\Domain\Model\PostId;

final class DeletePostCommand implements Command
{
    private $postId;

    public function __construct(string $id)
    {
        $this->postId = new PostId($id);
    }

    public function postId() : PostId
    {
        return $this->postId;
    }
}
