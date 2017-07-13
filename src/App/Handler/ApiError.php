<?php

namespace USaq\App\Handler;

use Crell\ApiProblem\ApiProblem;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use USaq\App\Exception\USaqApplicationException;

/**
 * Class to define an application error.
 */
class ApiError
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * ApiError constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, \Throwable $throwable)
    {
        $this->logger->critical($throwable->getMessage());
        $this->logger->critical(json_encode($throwable->getTrace(), JSON_UNESCAPED_SLASHES));

        if ($throwable instanceof USaqApplicationException) {
            $problem = $this->generateSpecificApiProblem($throwable);
        } elseif ($throwable instanceof \Exception) {
            $problem = $this->generateGeneralApiProblem($throwable);
        } else {
            $problem = $this->generateApiProblem($throwable);
        }

        $body = $problem->asJson(true);

        $response->getBody()->write($body);

        return $response
            ->withStatus($problem->getStatus())
            ->withHeader("Content-type", "application/problem+json");
    }

    protected function generateApiProblem(\Throwable $e): ApiProblem
    {
        $problem = new ApiProblem('Internal error', "about:blank");
        $problem->setDetail('An internal error has occurred. ');
        $problem->setStatus(500);

        return $problem;
    }

    protected function generateGeneralApiProblem(\Exception $e): ApiProblem
    {
        $problem = new ApiProblem('General error', "about:blank");
        $problem->setDetail('An error has occurred due to request. Please retry in a few minutes.');
        $problem->setStatus($e->getCode() >= 100 ? $e->getCode() : 400);

        return $problem;
    }

    protected function generateSpecificApiProblem(USaqApplicationException $e): ApiProblem
    {
        $problem = new ApiProblem($e->getTitle(), "about:blank");
        $problem->setDetail($e->getMessage());
        $problem->setStatus($e->getCode() >= 100 ? $e->getCode() : 400);

        foreach ($e->getExtensionData() as $key => $value) {
            $problem[$key] = $value;
        }

        return $problem;
    }
}
