<?php

namespace USaq\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use USaq\Services\UserServices\AuthenticationService;
use USaq\Services\Validation\ValidationService;
use USaq\Templating\EngineInterface;

/**
 * Class AuthenticationController.
 *
 * Provide authentication operations.
 *
 * @package USaq\Controller
 */
class AuthenticationController
{
    /**
     * @var AuthenticationService
     */
    private $authService;

    /**
     * @var ValidationService
     */
    private $validator;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * AuthenticationController constructor.
     *
     * @param AuthenticationService $authService
     * @param ValidationService $validator
     * @param EngineInterface $engine
     */
    public function __construct(AuthenticationService $authService, ValidationService $validator, EngineInterface $engine)
    {
        $this->authService = $authService;
        $this->validator = $validator;
        $this->engine = $engine;
    }

    /**
     * Action to register an user.
     * 
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function register(Request $request, Response $response): Response
    {
        $userData = $request->getParsedBody();

        $this->validator->validateRegisterRequest($userData);

        $this->authService->registerUser($userData);

        return $response;
    }

    /**
     * Action for the login.
     * 
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function login(Request $request, Response $response): Response
    {
        $userCredentials = $request->getParsedBody();

        $this->validator->validateLoginRequest($userCredentials);

        $token = $this->authService->loginUser($userCredentials);

        // Data to be rendered
        $data = [
            'resource' => $token,
            'meta' => [
                'actual_date' => (new \DateTime())->format('Y-m-d H:i:s')
            ]
        ];

        return $this->engine->render('\USaq\Templating\Fractal\Transformers\TokenTransformer', $data, $response);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function logout(Request $request, Response $response): Response
    {
        $this->authService->logoutUser($request->getHeader('X-Auth-Token')[0]);

        return $response;
    }
}
