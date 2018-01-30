<?php

namespace App\Kernel\Application\Command;

interface CommandHandler
{
    public function handle(Command $command = null);
}
