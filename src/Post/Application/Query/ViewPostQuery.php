<?php

declare(strict_types = 1);

namespace App\Post\Application\Query;

use App\Kernel\Application\Query\Query;
use App\Post\Domain\Model\PostId;

final class ViewPostQuery implements Query
{
    private $postId;

    public function __construct(string $postId)
    {
        $this->postId = new PostId($postId);
    }

    public function postId() : PostId
    {
        return $this->postId;
    }
}
