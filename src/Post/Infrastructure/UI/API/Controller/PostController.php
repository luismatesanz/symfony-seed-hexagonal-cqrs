<?php

namespace App\Post\Infrastructure\UI\API\Controller;

use App\Kernel\Application\Command\CommandBus;
use App\Post\Application\Command\AddPostCommand;
use App\Post\Application\Command\UpdatePostCommand;
use App\Post\Application\Query\ViewPostRequest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class PostController extends FOSRestController
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * GET post
     *
     * @Rest\View()
     */
    public function getPostAction(int $id): Response
    {
        $post = $this->get('post_view_service')->execute(new ViewPostRequest($id));

        $view = $this->view($post, Response::HTTP_OK);
        return $this->handleView($view);
    }


    /**
     * Add post.
     *
     * @Rest\View()
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="Bla Bla Bla",
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
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="Bla Bla Bla",
     *     @Model(type=App\Post\Application\Command\UpdatePostCommand::class)
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns"
     * )
     */
    public function putPostsAction(Request $request, int $id): Response
    {
        $date = \DateTime::createFromFormat('Y-m-d', $request->get('date'));
        $title = $request->get('title');
        $text = $request->get('text');

        $this->commandBus->execute(
            new UpdatePostCommand($id, $date, $title, $text)
        );

        return new Response(
            json_encode('OK')
        );
    }

}