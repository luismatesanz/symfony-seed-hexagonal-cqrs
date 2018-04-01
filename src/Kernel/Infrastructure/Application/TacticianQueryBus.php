<?php

namespace App\Kernel\Infrastructure\Application;

use App\Kernel\Application\Query\Query;
use App\Kernel\Application\Query\QueryBus;

class TacticianQueryBus implements QueryBus
{
    private $queryBus;

    public function __construct(\League\Tactician\CommandBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function execute(Query $query)
    {
        return $this->queryBus->handle($query);
    }
}
