<?php

declare(strict_types = 1);

namespace App\Post\Application\Query;

final class ViewPostsResponse
{
    private $posts;

    public function __construct(?array $posts = null)
    {
        foreach ($posts as $key => $post) {
            $this->posts[$key] = new ViewPostResponse($post);
        }
    }

    public function posts() : ?array
    {
        return $this->posts;
    }
}
