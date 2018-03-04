<?php

declare(strict_types = 1);

namespace App\Post\Infrastructure\UI\API\Controller;

use App\Kernel\Application\Command\CommandBus;
use App\Kernel\Infrastructure\UI\Form\Error\ErrorFormResponse;
use App\Post\Application\Command\AddPostCommand;
use App\Post\Application\Command\DeletePostCommand;
use App\Post\Application\Command\UpdatePostCommand;
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
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
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
     *         @Model(type=App\Post\Application\Query\ViewPostsResponse::class)
     *     )
     * )
     */
    public function getPostsAction($limit, $page, $dateStart, $dateEnd): Response
    {
        $limit = ($limit) ? intval($limit) : null;
        $page = ($page) ? intval($page) : null;
        $dateStart = ($dateStart) ? \DateTime::createFromFormat('Y-m-d', $dateStart) : null;
        $dateEnd = ($dateEnd) ? \DateTime::createFromFormat('Y-m-d', $dateEnd)  : null;

        $post = $this->get('posts_view_query_handler')->execute(new ViewPostsQuery($limit, $page, $dateStart, $dateEnd));

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
            $post = $this->get('post_view_query_handler')->execute(new ViewPostQuery($id));
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
     *     description="Returns"
     * )
     */
    public function postPostAction(Request $request): Response
    {
        $form = $this->createForm(PostAddType::class, null, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addPostCommand = $form->getData();
            $this->commandBus->execute($addPostCommand);
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

        $view = $this->view(array('message' => 'Add post'), Response::HTTP_OK);
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
     *     description="Returns"
     * )
     */
    public function putPostsAction(Request $request, string $id): Response
    {
        $form = $this->createForm(PostUpdateType::class, null, ['method' => 'PUT', 'id' => $id]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $updatePostCommand = $form->getData();
            $this->commandBus->execute($updatePostCommand);
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

        $view = $this->view(array('message' => 'Update post'), Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * Delete post.
     *
     * @Rest\View()
     *
     * @SWG\Tag(name="post")
     * @SWG\Parameter(
     *     name="",
     *     in="body",
     *     description="Delete Post",
     *     type="object",
     *     @Model(
     *          type=App\Post\Application\Command\DeletePostCommand::class
     *     )
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns"
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
