<?php

namespace App\Post\Application\Query;

use App\Kernel\Application\Query\Query;
use App\Post\Domain\Model\PostId;

class ViewPostQuery implements Query
{
    private $postId;

    public function __construct(PostId $postId)
    {
        $this->postId = $postId;
    }

    public function postId() : PostId
    {
        return $this->postId;
    }
}
