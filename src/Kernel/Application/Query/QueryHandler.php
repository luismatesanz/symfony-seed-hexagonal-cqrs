<?php

namespace App\Kernel\Application\Query;

interface QueryHandler
{
    public function execute(Query $request = null);
}