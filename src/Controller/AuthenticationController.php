<?php

namespace USaq\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use USaq\Model\Entity\User;
use USaq\Service\AuthenticationService;
use USaq\Service\Validation\ValidationService;
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
    private $authService;

    private $validator;

    private $engine;

    /**
     * AuthenticationController constructor.
     *
     * @param AuthenticationService $authService
     * @param ValidationService $validator
     * @param EngineInterface $engine
     */
    public function __construct(AuthenticationService $authService,  ValidationService $validator, EngineInterface $engine)
    {
        $this->authService = $authService;
        $this->validator = $validator;
        $this->engine = $engine;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function register(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();

        $this->validator->validateRegisterRequest($body);

        $this->authService->createUser($body['username'], $body['password']);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function login(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();

        $this->validator->validateLoginRequest($body);

        $token = $this->authService->loginUser($body['username'], $body['password']);

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
