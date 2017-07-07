<?php

namespace USaq\App\Handler;


use Crell\ApiProblem\ApiProblem;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;

class ApiError
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, \Throwable $exception)
    {
        $this->logger->critical($exception->getMessage());
        $status = $exception->getCode() ?: 500;
        $problem = new ApiProblem($exception->getMessage(), "about:blank");
        $problem->setStatus($status);
        $body = $problem->asJson(true);

        $response->getBody()->write($body);

        return $response
            ->withStatus($status)
            ->withHeader("Content-type", "application/problem+json");
    }
}