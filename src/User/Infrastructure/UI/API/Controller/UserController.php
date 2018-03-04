<?php

namespace App\User\Infrastructure\UI\API\Controller;

use App\Kernel\Application\Command\CommandBus;
use App\User\Application\Command\DeleteUserCommand;
use App\User\Application\Query\ViewUserQuery;
use App\User\Application\Query\ViewUsersQuery;
use App\User\Infrastructure\UI\API\Form\UserAddType;
use App\User\Infrastructure\UI\API\Form\UserUpdateType;
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
     *     @Model(type=App\User\Infrastructure\UI\API\Form\UserAddType::class)
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns"
     * )
     */
    public function postUserAction(Request $request): Response
    {
        $form = $this->createForm(UserAddType::class, null, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addUserCommand = $form->getData();
            $this->commandBus->execute($addUserCommand);
        } else {
            $errors = [];
            foreach ($form->getErrors(true) as $key => $error) {
                $errors[] = array(
                    "cause" => $error->getCause(),
                    "description" => $error->getMessage(),
                );
            }
            $view = $this->view(array('error' => $errors), Response::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        $view = $this->view(array('message' => 'Add user'), Response::HTTP_OK);
        return $this->handleView($view);
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
     *     @Model(type=App\User\Infrastructure\UI\API\Form\UserUpdateType::class)
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns"
     * )
     */
    public function putUsersAction(Request $request, string $id): Response
    {
        $form = $this->createForm(UserUpdateType::class, null, ['method' => 'PUT', 'id' => $id]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $updateUserCommand = $form->getData();
            $this->commandBus->execute($updateUserCommand);
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

        $view = $this->view(array('message' => 'Update user'), Response::HTTP_OK);
        return $this->handleView($view);
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

        $view = $this->view(array('message' => 'Delete user'), Response::HTTP_OK);
        return $this->handleView($view);
    }
}
