<?php

namespace USaq\App\Handler;

use Crell\ApiProblem\ApiProblem;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Define not found error.
 */
class NotFoundError
{
    public function __invoke(Request $request, Response $response)
    {
        $problem = new ApiProblem(
            "Not found",
            "http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html"
        );
        $problem->setStatus(404);
        $body = $problem->asJson(true);

        $response->getBody()->write($body);

        return $response
            ->withStatus(404)
            ->withHeader("Content-type", "application/problem+json");
    }
}
