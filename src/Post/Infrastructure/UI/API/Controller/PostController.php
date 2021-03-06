<?php

declare(strict_types = 1);

namespace App\Post\Infrastructure\UI\API\Controller;

use App\Kernel\Application\Command\CommandBus;
use App\Kernel\Application\Query\QueryBus;
use App\Post\Application\Command\DeletePostCommand;
use App\Post\Application\Query\ViewPostQuery;
use App\Post\Application\Query\ViewPostsQuery;
use App\Post\Infrastructure\UI\API\Form\PostAddType;
use App\Post\Infrastructure\UI\API\Form\PostUpdateType;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

final class PostController extends FOSRestController
{
    private $queryBus;
    private $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * GET posts
     *
     * @Rest\View()
     * @Rest\QueryParam(name="limit", description="Limit")
     * @Rest\QueryParam(name="page", description="Page")
     * @Rest\QueryParam(name="dateStart", description="Filter date start")
     * @Rest\QueryParam(name="dateEnd", description="Filter date end")
     *
     * @SWG\Tag(name="post")
     * @SWG\Response(
     *     response=200,
     *     description="Returns all posts",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=App\Post\Application\Query\ViewPostResponse::class)
     *     )
     * )
     */
    public function getPostsAction($limit, $page, $dateStart, $dateEnd): Response
    {
        $limit = ($limit) ? intval($limit) : null;
        $page = ($page) ? intval($page) : null;
        $dateStart = ($dateStart) ? \DateTime::createFromFormat('Y-m-d', $dateStart) : null;
        $dateEnd = ($dateEnd) ? \DateTime::createFromFormat('Y-m-d', $dateEnd)  : null;

        $post = $this->queryBus->execute(new ViewPostsQuery($limit, $page, $dateStart, $dateEnd));

        $view = $this->view($post->posts(), Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * GET post
     *
     * @Rest\View()
     *
     * @SWG\Tag(name="post")
     * @SWG\Response(
     *     response=200,
     *     description="Returns post",
     *     @SWG\Schema(
     *         @Model(type=App\Post\Application\Query\ViewPostResponse::class)
     *     )
     * )
     */
    public function getPostAction(string $id): Response
    {
        try {
            $post = $this->queryBus->execute(new ViewPostQuery($id));
            $view = $this->view($post, Response::HTTP_OK);
        } catch (\Exception $e) {
            $view = $this->view(array('error' => 'No content'), Response::HTTP_NO_CONTENT);
        } catch (\InvalidArgumentException $e) {
            $view = $this->view(array('error' => 'No content'), Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }


    /**
     * Add post.
     *
     * @Rest\View()
     *
     * @SWG\Tag(name="post")
     * @SWG\Parameter(
     *     name="",
     *     in="body",
     *     description="Add Post",
     *     type="object",
     *     @Model(type=App\Post\Infrastructure\UI\API\Form\PostAddType::class)
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns post",
     *     @SWG\Schema(
     *         @Model(type=App\Post\Application\Query\ViewPostResponse::class)
     *     )
     * )
     */
    public function postPostAction(Request $request): Response
    {
        $form = $this->createForm(PostAddType::class, null, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addPostCommand = $form->getData();
            try {
                $postId = $this->commandBus->execute($addPostCommand);
            } catch (\Exception $e ){
                $view = $this->view(array($e->getMessage()), Response::HTTP_BAD_REQUEST);
                return $this->handleView($view);
            }
        } else {
            $errors = [];
            foreach ($form->getErrors(true) as $key => $error) {
                $errors[] = array(
                    "field" => '',
                    "description" => $error->getMessage(),
                );
            }
            $view = $this->view(array('error' => $errors), Response::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        $view = $this->view($postId, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * Update post.
     *
     * @Rest\View()
     *
     * @SWG\Tag(name="post")
     * @SWG\Parameter(
     *     name="",
     *     in="body",
     *     description="Update Post",
     *     type="object",
     *     @Model(type=App\Post\Infrastructure\UI\API\Form\PostUpdateType::class)
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns post",
     *     @SWG\Schema(
     *         @Model(type=App\Post\Application\Query\ViewPostResponse::class)
     *     )
     * )
     */
    public function putPostsAction(Request $request, string $id): Response
    {
        $form = $this->createForm(PostUpdateType::class, null, ['method' => 'PUT', 'id' => $id]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $updatePostCommand = $form->getData();
            $post = $this->commandBus->execute($updatePostCommand);
        } else {
            $errors = [];
            foreach ($form->getErrors(true) as $key => $error) {
                $errors[] = array(
                    "field" => '',
                    "description" => $error->getMessage(),
                );
            }
            $view = $this->view(array('error' => $errors), Response::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        $view = $this->view($post, Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * Delete post.
     *
     * @Rest\View()
     *
     * @SWG\Tag(name="post")
     * @SWG\Response(
     *     response=200,
     *     description="Returns message modify"
     * )
     */
    public function deletePostsAction(string $id): Response
    {
        $this->commandBus->execute(
            new DeletePostCommand($id)
        );

        $view = $this->view(array('message' => 'Delete post'), Response::HTTP_OK);
        return $this->handleView($view);
    }
}
