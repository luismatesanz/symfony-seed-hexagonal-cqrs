<?php

namespace App\User\Infrastructure\UI\API\Controller;

use App\Kernel\Application\Command\CommandBus;
use App\User\Application\Command\AddUserCommand;
use App\User\Application\Command\DeleteUserCommand;
use App\User\Application\Command\UpdateUserCommand;
use App\User\Application\Query\ViewUserQuery;
use App\User\Application\Query\ViewUsersQuery;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

final class UserController extends FOSRestController
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * GET users
     *
     * @Rest\View()
     * @Rest\QueryParam(name="limit", description="Limit")
     * @Rest\QueryParam(name="page", description="Page")
     *
     * @SWG\Tag(name="user")
     * @SWG\Response(
     *     response=200,
     *     description="Returns all users",
     *     @SWG\Schema(
     *         @Model(type=App\User\Application\Query\ViewUsersResponse::class)
     *     )
     * )
     */
    public function getUsersAction($limit, $page): Response
    {
        $limit = ($limit) ? intval($limit) : null;
        $page = ($page) ? intval($page) : null;

        $user = $this->get('users_view_query_handler')->execute(new ViewUsersQuery($limit, $page));

        $view = $this->view($user->users(), Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * GET user
     *
     * @Rest\View()
     *
     * @SWG\Tag(name="user")
     * @SWG\Response(
     *     response=200,
     *     description="Returns user",
     *     @SWG\Schema(
     *         @Model(type=App\User\Application\Query\ViewUserResponse::class)
     *     )
     * )
     */
    public function getUserAction(string $id): Response
    {
        try {
            $user = $this->get('user_view_query_handler')->execute(new ViewUserQuery($id));
            $view = $this->view($user, Response::HTTP_OK);
        } catch (\Exception $e) {
            $view = $this->view(array('error' => 'No content'), Response::HTTP_NO_CONTENT);
        } catch (\InvalidArgumentException $e) {
            $view = $this->view(array('error' => 'No content'), Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }


    /**
     * Add user.
     *
     * @Rest\View()
     *
     * @SWG\Tag(name="user")
     * @SWG\Parameter(
     *     name="",
     *     in="body",
     *     description="Add User",
     *     type="object",
     *     @Model(type=App\User\Application\Command\AddUserCommand::class)
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns"
     * )
     */
    public function postUserAction(Request $request): Response
    {
        $username = ($request->get('username')) ? $request->get('username') : null;
        $email = ($request->get('email')) ? $request->get('email') : null;
        $password = ($request->get('password')) ? $request->get('password') : null;
        if (!$username) {
            return new Response(
                json_encode('Username required')
            );
        }
        if (!$email) {
            return new Response(
                json_encode('Email required')
            );
        }
        if (!$password) {
            return new Response(
                json_encode('Password required')
            );
        }

        try {
            $this->commandBus->execute(
                new AddUserCommand($username, $email, $password)
            );
        } catch (\Exception $e) {
            return new Response(
                json_encode($e->getMessage())
            );
        }

        return new Response(
            json_encode('OK')
        );
    }

    /**
     * Update user.
     *
     * @Rest\View()
     *
     * @SWG\Tag(name="user")
     * @SWG\Parameter(
     *     name="",
     *     in="body",
     *     description="Update User",
     *     type="object",
     *     @Model(type=App\User\Application\Command\UpdateUserCommand::class)
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns"
     * )
     */
    public function putUsersAction(Request $request, string $id): Response
    {
        $username = ($request->get('username')) ? $request->get('username') : null;
        $email = ($request->get('email')) ? $request->get('email') : null;
        $enabled = ($request->get('enabled')) ? $request->get('enabled') : null;
        if (!$username) {
            return new Response(
                json_encode('Username required')
            );
        }
        if (!$email) {
            return new Response(
                json_encode('Email required')
            );
        }
        if (!$enabled) {
            return new Response(
                json_encode('Enabled required')
            );
        }

        $this->commandBus->execute(
            new UpdateUserCommand($id, $username, $email, $enabled)
        );

        return new Response(
            json_encode('OK')
        );
    }


    /**
     * Delete user.
     *
     * @Rest\View()
     *
     * @SWG\Tag(name="user")
     * @SWG\Parameter(
     *     name="",
     *     in="body",
     *     description="Delete User",
     *     type="object",
     *     @Model(
     *          type=App\User\Application\Command\DeleteUserCommand::class
     *     )
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns"
     * )
     */
    public function deleteUsersAction(string $id): Response
    {
        $this->commandBus->execute(
            new DeleteUserCommand($id)
        );

        return new Response(
            json_encode('OK')
        );
    }
}
