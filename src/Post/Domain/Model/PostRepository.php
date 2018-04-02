<?php

declare(strict_types = 1);

namespace App\Post\Domain\Model;

interface PostRepository
{
    public function nextIdentity() : PostId;

    public function all(?int $limit = null, ?int $page = null, ?\DateTime $dateStart = null, ?\DateTime $dateEnd = null) : array;

    public function ofId(PostId $id) : ?Post;

    public function add(Post $post) : void;

    public function remove(Post $post) : void;
}
