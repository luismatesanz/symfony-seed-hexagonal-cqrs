<?php

declare(strict_types = 1);

namespace App\User\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Kernel\Application\Command\CommandHandler;
use App\User\Domain\Model\UserRepository;

final class DeleteUserCommandHandler implements CommandHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Command $command = null)
    {
        $user = $this->userRepository->ofId($command->userId());
        $this->userRepository->remove($user);
    }
}
