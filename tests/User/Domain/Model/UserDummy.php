<?php

declare(strict_types = 1);

namespace App\Tests\User\Domain\Model;

use App\User\Domain\Model\User;
use App\User\Domain\Model\UserId;

class UserDummy
{
    public static function create(UserId $id, $username, $email, $password) : User
    {
        return new User(
            $id,
            $username,
            $email,
            $password
        );
    }
}
