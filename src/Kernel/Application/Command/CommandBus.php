<?php

namespace App\Kernel\Application\Command;

interface CommandBus
{
    public function execute(Command $command);
}
