<?php

declare(strict_types = 1);

namespace App\User\Application\Query;

use App\Kernel\Application\Query\Query;
use App\Kernel\Application\Query\QueryHandler;
use App\User\Domain\Model\UserDoesNotExistException;
use App\User\Domain\Model\UserRepository;

final class ViewUserQueryHandler implements QueryHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(Query $request = null) : ViewUserResponse
    {
        $userId = $request->userId();

        $user = $this->userRepository->ofId($userId);

        if (!$user) {
            throw new UserDoesNotExistException();
        }

        /*if (!$user->id()->equals(new UserId($userId))) {
            throw new \InvalidArgumentException('User is not authorized to view this wish');
        }*/

        return new ViewUserResponse($user);
    }
}
