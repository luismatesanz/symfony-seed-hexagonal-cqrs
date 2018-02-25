<?php

declare(strict_types = 1);

namespace App\Post\Application\Query;

use App\Kernel\Application\Query\Query;
use App\Kernel\Application\Query\QueryHandler;
use App\Kernel\Application\Query\Response;
use App\Post\Domain\Model\PostRepository;

final class ViewPostsQueryHandler implements QueryHandler
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(Query $request = null) : ViewPostsResponse
    {
        $posts = $this->postRepository->all(
            $request->limit(),
            $request->page(),
            $request->dateStart(),
            $request->dateEnd()
            );
        return new ViewPostsResponse($posts);
    }
}
