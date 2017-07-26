<?php

namespace USaq\Provider;

use Gofabian\Negotiation\NegotiationMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tuupola\Middleware\Cors;
use USaq\App\ServiceProvider\ServiceProviderInterface;

/**
 * Provides middleware configuration.
 */
class MiddlewareProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function registerServices(): array
    {
        return [
            Cors::class => function (ContainerInterface $container) {
                return new Cors([
                    "logger" => $container->get('logger'),
                    "origin" => ["*"],
                    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
                    "headers.allow" => ["Accept", "Content-Type", "X-Auth-Token"],
                    "headers.expose" => [],
                    "cache" => 60,
                    "error" => function (ServerRequestInterface $request, ResponseInterface $response, $arguments) {
                        $data["status"] = "error";
                        $data["message"] = $arguments['message'];

                        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

                        return $response
                            ->withHeader("Content-Type", "application/json");
                    }
                ]);
            },

            NegotiationMiddleware::class => function (ContainerInterface $container) {
                return new NegotiationMiddleware([
                    "accept" => ["application/json"]
                ]);
            }
        ];
    }

    /**
     * @inheritdoc
     */
    public function registerServicesDevelopment(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function registerServicesTest(): array
    {
        return [];
    }
}
