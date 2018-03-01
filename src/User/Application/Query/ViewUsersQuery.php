<?php

declare(strict_types = 1);

namespace App\User\Application\Query;

use App\Kernel\Application\Query\Query;

final class ViewUsersQuery implements Query
{
    private $limit;
    private $page;

    public function __construct(?int $limit = null, ?int $page = null)
    {
        $this->limit = $limit;
        $this->page = $page;
    }

    public function limit() : ?int
    {
        return $this->limit;
    }

    public function page() : ?int
    {
        return $this->page;
    }
}
