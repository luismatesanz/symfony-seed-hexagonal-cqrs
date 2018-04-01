<?php

namespace App\Kernel\Application\Query;

interface QueryBus
{
    public function execute(Query $query);
}
