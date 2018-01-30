<?php

namespace App\Post\Domain\Model;

use App\Post\Application\Query\ViewPostsQuery;

interface PostRepository
{
    public function nextIdentity() : PostId;

    public function all(ViewPostsQuery $postsQuery) : array;

    public function ofId(PostId $id) : ?Post;

    public function add(Post $post) : void;

    public function update(Post $post) : void;

    public function remove(Post $post) : void;
}
