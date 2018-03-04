<?php

declare(strict_types = 1);

namespace App\Tests\Post\Domain\Model;

use App\Post\Domain\Model\Post;
use App\Post\Domain\Model\PostId;

final class PostDummy
{
    public static function create(PostId $id, string $date, string $title, ?string $text) : Post
    {
        return new Post(
            $id,
            new \DateTime($date),
            $title,
            $text
        );
    }
}
