<?php

namespace USaq\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Route;
use USaq\Model\Entity\User;
use USaq\Services\UserServices\Exception\PermissionDeniedException;

class PermissionMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        /** @var User $user */
        $user = $request->getAttribute('user');
        /** @var Route $route */
        $route = $request->getAttribute('route');
        $identifier = $route->getArgument('identifier');

        if ($user->getId() !== (int)$identifier) {
            throw new PermissionDeniedException('User don\'t have permission to act on this resource');
        }

        $response = $next($request, $response);
        return $response;
    }
}