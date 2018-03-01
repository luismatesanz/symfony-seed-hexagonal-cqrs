<?php

namespace App\Post\Infrastructure\UI\API\Controller;

use App\Kernel\Application\Command\CommandBus;
use App\Post\Application\Command\AddPostCommand;
use App\Post\Application\Command\Aggregate\PostCommentCommand;
use App\Post\Application\Command\DeletePostCommand;
use App\Post\Application\Command\UpdatePostCommand;
use App\Post\Application\Query\ViewPostQuery;
use App\Post\Application\Query\ViewPostsQuery;
use Doctrine\Common\Collections\ArrayCollection;
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
     *     @Model(type=App\Post\Application\Command\AddPostCommand::class)
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns"
     * )
     */
    public function postPostAction(Request $request): Response
    {
        $date = \DateTime::createFromFormat('Y-m-d', $request->get('date'));
        $title = $request->get('title');
        $text = $request->get('text');

        $this->commandBus->execute(
            new AddPostCommand($date, $title, $text)
        );

        return new Response(
            json_encode('OK')
        );
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
     *     @Model(type=App\Post\Application\Command\UpdatePostCommand::class)
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns"
     * )
     */
    public function putPostsAction(Request $request, string $id): Response
    {
        $date = ($request->get('date')) ? \DateTime::createFromFormat('Y-m-d', $request->get('date')) : null;
        $title = ($request->get('title')) ? $request->get('title'): null;
        $text = ($request->get('text')) ? $request->get('text') : null;
        $commentsRequest = ($request->get('comments')) ? $request->get('comments') : array();

        if (!$title) {
            return new Response(
                json_encode('Title required')
            );
        }

        $comments = new ArrayCollection();
        foreach ($commentsRequest as $comment) {
            $commentId = (array_key_exists('id', $comment)) ? $comment['id'] : null;
            $commentUserId = (array_key_exists('userId', $comment)) ? $comment['userId'] : null;
            $commentText = (array_key_exists('text', $comment)) ? $comment['text'] : null;
            $comments->add(new PostCommentCommand($commentId, $commentUserId, $commentText));
        }

        $this->commandBus->execute(
            new UpdatePostCommand($id, $date, $title, $text, $comments)
        );

        return new Response(
            json_encode('OK')
        );
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

        return new Response(
            json_encode('OK')
        );
    }
}
