<?php

namespace USaq\App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthenticationMiddleware
{
    function __invoke(Request $request, Response $response, callable $next)
    {
    }
}