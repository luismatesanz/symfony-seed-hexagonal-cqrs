<?php

namespace App\Post\Application\Query;

use App\Kernel\Application\Query\Query;
use App\Post\Domain\Model\PostId;

class ViewPostQuery implements Query
{
    private $idPost;

    public function __construct(PostId $idPost)
    {
        $this->idPost = $idPost;
    }

    public function idPost() : PostId
    {
        return $this->idPost;
    }
}