<?php

namespace USaq\Controller;

use Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use USaq\Service\AuthenticationService;
use USaq\Service\Validation\ValidationService;

class AuthenticationController
{
    private $authService;

    private $logger;

    private $validator;

    public function __construct(AuthenticationService $authService, LoggerInterface $logger, ValidationService $validator)
    {
        $this->authService = $authService;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    public function register(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $errors = $this->validator->validateRegisterRequest($body);

        if ($errors) {
            return $response->withJson(['errors' => true, 'message' => $errors]);
        }

        $this->authService->createUser($body['username'], $body['password']);

        $resource = ['result' => 'OK'];

        return $response->withJson($resource);
    }

    public function login(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $errors = $this->validator->validateLoginRequest($body);

        if ($errors) {
            return $response->withJson($errors);
        }

        $token = $this->authService->loginUser($body['username'], $body['password']);

        $resource = ['token' => $token->getTokenString()];

        return $response->withJson($resource);
    }

    public function logout(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $user = $this->authService->retrieveUserByToken($body['token']);

        $resource = ['username' => $user->getUsername()];

        return $response->withJson($resource);
    }
}
