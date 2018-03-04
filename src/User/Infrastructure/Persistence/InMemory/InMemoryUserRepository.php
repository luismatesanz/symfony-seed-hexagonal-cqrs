<?php

declare(strict_types = 1);

namespace App\User\Infrastructure\Persistence\InMemory;

use App\User\Domain\Model\User;
use App\User\Domain\Model\UserId;
use App\User\Domain\Model\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    public $users = array();

    public function nextIdentity() : UserId
    {
        return new UserId();
    }

    public function all(?int $limit = null, ?int $page = null) : array
    {
        return $this->users;
    }

    public function ofId(UserId $id) : ?User
    {
        if (!isset($this->users[$id->id()])) {
            return null;
        }

        return $this->users[$id->id()];
    }

    public function of(?string $username, ?string $email) : ?User
    {
        $userByName = null;
        if ($username) {
            $arrayUsername = array_column($this->users, 'username');
            $userByName = array_search($username, $arrayUsername);
            if ($userByName) {
                return $userByName;
            }
        }

        $userByEmail = null;
        if ($email) {
            $arrayEmail = array_column($this->users, 'email');
            $userByEmail = array_search($email, $arrayEmail);
            if ($email) {
                return $userByEmail;
            }
        }

        return null;
    }

    public function add(User $user) : void
    {
        $this->users[$user->id()->id()] = $user;
    }

    public function update(User $user) : void
    {
        $this->users[$user->id()->id()] = $user;
    }

    public function remove(User $user) : void
    {
        unset($this->users[$user->id()->id()]);
    }
}
