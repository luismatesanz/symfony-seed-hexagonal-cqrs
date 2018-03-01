<?php

declare(strict_types = 1);

namespace App\User\Application\Query;

final class ViewUsersResponse
{
    private $users;

    public function __construct(?array $users = null)
    {
        foreach ($users as $key => $user) {
            $this->users[$key] = new ViewUserResponse($user);
        }
    }

    public function users() : array
    {
        return $this->users;
    }
}
