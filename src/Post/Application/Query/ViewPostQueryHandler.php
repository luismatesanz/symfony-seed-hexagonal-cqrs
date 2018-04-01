<?php

declare(strict_types = 1);

namespace App\Post\Application\Query;

use App\Kernel\Application\Query\QueryHandler;
use App\Post\Domain\Model\PostDoesNotExistException;
use App\Post\Domain\Model\PostRepository;

final class ViewPostQueryHandler implements QueryHandler
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handle(ViewPostQuery $request = null) : ViewPostResponse
    {
        $postId = $request->postId();

        $post = $this->postRepository->ofId($postId);

        if (!$post) {
            throw new PostDoesNotExistException();
        }

        /*if (!$post->id()->equals(new PostId($postId))) {
            throw new \InvalidArgumentException('Post is not authorized to view this wish');
        }*/

        return new ViewPostResponse($post);
    }
}
