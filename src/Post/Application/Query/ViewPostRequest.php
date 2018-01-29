<?php

namespace App\Post\Application\Query;

use App\Kernel\Application\Query\ApplicationRequest;

class ViewPostRequest implements ApplicationRequest
{
    private $idPost;

    public function __construct($idPost)
    {
        $this->idPost = $idPost;
    }

    public function idPost()
    {
        return $this->idPost;
    }
}