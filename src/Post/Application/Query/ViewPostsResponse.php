<?php

declare(strict_types = 1);

namespace App\Post\Application\Query;

class ViewPostsResponse
{
    private $posts;

    public function __construct(?array $posts = null)
    {
        foreach ($posts as $post) {
            $this->posts[] = new ViewPostResponse($post);
        }
    }

    public function posts() : array
    {
        return $this->posts;
    }
}
