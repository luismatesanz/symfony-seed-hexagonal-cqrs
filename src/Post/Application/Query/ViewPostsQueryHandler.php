<?php

namespace App\Post\Application\Query;

use App\Kernel\Application\Query\Query;
use App\Kernel\Application\Query\QueryHandler;
use App\Post\Domain\Model\PostRepository;

class ViewPostsQueryHandler implements QueryHandler
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(Query $request = null)
    {
        return $this->postRepository->all($request);
    }
}