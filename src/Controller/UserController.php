<?php

namespace USaq\Controller;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use USaq\Model\Entity\User;
use USaq\Services\UserServices\UserService;
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
     * @var EngineInterface
     */
    private $engine;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     * @param EngineInterface $engine
     */
    public function __construct(UserService $userService, EngineInterface $engine)
    {
        $this->userService = $userService;
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
    public function list(Request $request, Response $response, int $identifier): Response
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
}
