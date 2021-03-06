<?php

declare(strict_types = 1);

namespace App\User\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Kernel\Application\Command\CommandHandler;
use App\User\Application\Query\ViewUserResponse;
use App\User\Domain\Model\User;
use App\User\Domain\Model\UserAlreadyExistException;
use App\User\Domain\Model\UserRepository;

final class AddUserCommandHandler implements CommandHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(AddUserCommand $command = null) : ViewUserResponse
    {
        if ($this->userRepository->of($command->username(), null)) {
            throw new UserAlreadyExistException("Username exists");
        }

        if ($this->userRepository->of(null, $command->email())) {
            throw new UserAlreadyExistException("Email exists");
        }

        $user = new User($this->userRepository->nextIdentity(), $command->username(), $command->email(), $command->password());
        $this->userRepository->add($user);
        return new ViewUserResponse($user);
    }
}
