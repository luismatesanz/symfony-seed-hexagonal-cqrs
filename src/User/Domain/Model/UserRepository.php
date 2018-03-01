<?php


namespace App\User\Domain\Model;

interface UserRepository
{
    public function nextIdentity() : UserId;

    public function all(?int $limit = null, ?int $page = null) : array;

    public function ofId(UserId $id) : ?User;

    public function add(User $post) : void;

    public function update(User $post) : void;

    public function remove(User $post) : void;
}
