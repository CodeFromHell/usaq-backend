<?php

namespace USaq\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use USaq\Model\Exception\EntityNotFoundException;
use USaq\Services\UserServices\AuthenticationService;
use USaq\Services\UserServices\Exception\UnauthorizedException;

/**
 * Middleware to control user authentication.
 */
class AuthenticationMiddleware
{
    /**
     * @var AuthenticationService
     */
    private $authService;

    /**
     * AuthenticationMiddleware constructor.
     *
     * @param AuthenticationService $authService
     */
    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {
        try {
            if (!$request->hasHeader('X-Auth-Token')) {
                throw new UnauthorizedException("A token is needed");
            }

            $token = $request->getHeader('X-Auth-Token');

            if (count($token) !== 1) {
                throw new UnauthorizedException("No existe el token o se han pasado varios.");
            }

            // Find player or launch exception if not find one for token
            $user = $this->authService->retrieveUserByToken($token[0]);

            // Add player to request
            $request = $request->withAttribute('user', $user);
        } catch (UnauthorizedException | EntityNotFoundException $e) {
            throw new UnauthorizedException($e->getMessage());
        }

        $response = $next($request, $response);
        return $response;
    }
}
