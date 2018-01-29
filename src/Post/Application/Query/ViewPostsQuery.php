<?php

namespace App\Post\Application\Query;

use App\Kernel\Application\Query\Query;

class ViewPostsQuery implements Query
{
    private $dateStart;
    private $dateEnd;
    private $limit;
    private $page;

    public function __construct(?int $limit = null, ?int $page = null, ?\DateTime $dateStart = null, ?\DateTime $dateEnd = null)
    {
        $this->limit = $limit;
        $this->page = $page;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    public function dateStart() : ?\DateTime
    {
        return $this->dateStart;
    }

    public function dateEnd() : ?\DateTime
    {
        return $this->dateEnd;
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