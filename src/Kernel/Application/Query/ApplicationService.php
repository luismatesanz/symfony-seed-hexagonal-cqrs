<?php

namespace App\Kernel\Application\Query;

interface ApplicationService
{
    public function execute(ApplicationRequest $request = null);
}