<?php

namespace USaq\Controller;

use Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use USaq\Model\Entity\User;
use USaq\Service\AuthenticationService;
use USaq\Service\Validation\ValidationService;

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

    private $logger;

    private $validator;

    /**
     * AuthenticationController constructor.
     *
     * @param AuthenticationService $authService
     * @param LoggerInterface $logger
     * @param ValidationService $validator
     */
    public function __construct(AuthenticationService $authService, LoggerInterface $logger, ValidationService $validator)
    {
        $this->authService = $authService;
        $this->logger = $logger;
        $this->validator = $validator;
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

        $resource = ['result' => 'OK'];

        return $response->withJson($resource);
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

        $resource = ['token' => $token->getTokenString()];

        return $response->withJson($resource);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function logout(Request $request, Response $response): Response
    {
        /** @var User $user */
        $user = $request->getAttribute('user');

        $this->authService->logoutUser($request->getHeader('X-Auth-Token')[0]);

        $resource = [
            'message' => sprintf('User %s has been logout', $user->getUsername())
        ];

        return $response->withJson($resource);
    }
}
