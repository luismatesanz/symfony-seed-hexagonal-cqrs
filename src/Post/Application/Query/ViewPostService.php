<?php

namespace App\Post\Application\Query;

use App\Kernel\Application\Query\ApplicationRequest;
use App\Kernel\Application\Query\ApplicationService;
use App\Post\Domain\Model\PostRepository;

class ViewPostService implements ApplicationService
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(ApplicationRequest $request = null)
    {
        $idPost = $request->idPost();
        return $this->postRepository->ofId($idPost);
    }
}