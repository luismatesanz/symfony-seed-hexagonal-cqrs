<?php

declare(strict_types = 1);

namespace App\User\Application\Query;

use App\Kernel\Application\Query\Query;
use App\Kernel\Application\Query\QueryHandler;
use App\Kernel\Application\Query\Response;
use App\User\Domain\Model\UserRepository;

final class ViewUsersQueryHandler implements QueryHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(Query $request = null) : ViewUsersResponse
    {
        $users = $this->userRepository->all(
            $request->limit(),
            $request->page()
            );
        return new ViewUsersResponse($users);
    }
}
