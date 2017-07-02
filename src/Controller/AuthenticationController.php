<?php

namespace USaq\Controller;

use Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use USaq\Service\AuthenticationService;
use USaq\Service\ValidationService;

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

        if ($errors)
            return $response->withJson($errors);

        $resource = ['result' => 'OK'];

        return $response->withJson($resource);
    }
}
