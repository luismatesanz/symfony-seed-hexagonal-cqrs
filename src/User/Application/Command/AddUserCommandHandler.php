<?php

declare(strict_types = 1);

namespace App\User\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Kernel\Application\Command\CommandHandler;
use App\User\Domain\Model\User;
use App\User\Domain\Model\UserRepository;

final class AddUserCommandHandler implements CommandHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Command $command = null)
    {
        $this->userRepository->add(
            new User($this->userRepository->nextIdentity(), $command->username(), $command->email(), $command->password())
        );
    }
}
