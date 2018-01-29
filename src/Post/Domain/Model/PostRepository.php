<?php

namespace App\Post\Domain\Model;


interface PostRepository
{
    public function all() : array;

    public function ofId(int $id) : Post;

    public function add(Post $post) : void;

    public function update(Post $post) : void;

    public function remove(Post $post) : void;
}