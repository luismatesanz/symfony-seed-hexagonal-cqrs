<?php

namespace App\Kernel\Infrastructure\Application\Command;

use App\Kernel\Application\Command\Command;
use App\Kernel\Application\Command\CommandBus;

class SimpleCommandBus implements CommandBus
{
    private $commandBus;

    public function __construct(\SimpleBus\SymfonyBridge\Bus\CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function execute(Command $command) : void
    {
        $this->commandBus->handle($command);
    }
}