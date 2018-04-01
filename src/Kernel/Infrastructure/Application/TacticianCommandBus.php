<?php

namespace App\Kernel\Infrastructure\Application;

use App\Kernel\Application\Command\Command;
use App\Kernel\Application\Command\CommandBus;

class TacticianCommandBus implements CommandBus
{
    private $commandBus;

    public function __construct(\League\Tactician\CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function execute(Command $command)
    {
        return $this->commandBus->handle($command);
    }
}
