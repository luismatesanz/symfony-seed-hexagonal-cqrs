<?php

declare(strict_types = 1);

namespace App\Post\Infrastructure\Persistence\InMemory;

use App\Post\Domain\Model\Post;
use App\Post\Domain\Model\PostId;
use App\Post\Domain\Model\PostRepository;

class InMemoryPostRepository implements PostRepository
{
    public $posts = array();

    public function nextIdentity() : PostId
    {
        return new PostId();
    }

    public function all(?int $limit = null, ?int $page = null, ?\DateTime $dateStart = null, ?\DateTime $dateEnd = null) : array
    {
        return $this->posts;
    }

    public function ofId(PostId $id) : ?Post
    {
        if (!isset($this->posts[$id->id()])) {
            return null;
        }

        return $this->posts[$id->id()];
    }

    public function add(Post $post) : void
    {
        $this->posts[$post->id()->id()] = $post;
    }

    public function update(Post $post) : void
    {
        $this->posts[$post->id()->id()] = $post;
    }

    public function remove(Post $post) : void
    {
        unset($this->posts[$post->id()->id()]);
    }
}
