<?php

namespace USaq\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use USaq\Model\Entity\User;
use USaq\Services\UserServices\UserService;
use USaq\Services\Validation\ValidationService;
use USaq\Templating\EngineInterface;

/**
 * Class UserController.
 *
 * Provides actions to operate with users.
 *
 * @see User
 * @see UserService
 */
class UserController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var ValidationService
     */
    private $validator;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     * @param ValidationService $validator
     * @param EngineInterface $engine
     */
    public function __construct(UserService $userService, ValidationService $validator, EngineInterface $engine)
    {
        $this->userService = $userService;
        $this->validator = $validator;
        $this->engine = $engine;
    }

    /**
     * List all users except authenticated user.
     *
     * @param Request $request
     * @param Response $response
     * @param int $identifier       User id.
     * @return Response
     */
    public function showAllUsers(Request $request, Response $response, int $identifier): Response
    {
        $userList = $this->userService->getAllExcept([$identifier]);

        // Data to render
        $data = [
            'resource' => $userList,
            'meta' => [
                'count' => count($userList)
            ]
        ];

        return $this->engine->render('USaq\Templating\Fractal\Transformers\UserTransformer', $data, $response);
    }

    /**
     * Show user friends.
     *
     * @param Request $request
     * @param Response $response
     * @param int $identifier
     * @return Response
     */
    public function showUserFriends(Request $request, Response $response, int $identifier): Response
    {
        $userFriends = $this->userService->getUserFriends($identifier);

        $data = [
            'resource' => $userFriends,
            'isCollection' => true
        ];

        return $this->engine->render('USaq\Templating\Fractal\Transformers\UserTransformer', $data, $response);
    }

    /**
     * Add new friend to user.
     *
     * @param Request $request
     * @param Response $response
     * @param int $identifier
     * @return Response
     */
    public function addUserFriend(Request $request, Response $response, int $identifier): Response
    {
        $friendData = $request->getParsedBody();

        $this->validator->validateFriendDataRequest($friendData);

        $this->userService->addFriendForUser($identifier, $friendData['friend_id']);

        return $response;
    }

    /**
     * Remove user's friends.
     *
     * @param Request $request
     * @param Response $response
     * @param int $identifier
     * @return Response
     */
    public function removeUserFriend(Request $request, Response $response, int $identifier): Response
    {
        $friendData = $request->getParsedBody();

        $this->validator->validateFriendDataRequest($friendData);

        $this->userService->removeFriendForUser($identifier, $friendData['friend_id']);

        return $response;
    }
}
