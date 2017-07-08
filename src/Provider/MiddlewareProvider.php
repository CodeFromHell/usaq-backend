<?php

namespace USaq\Provider;

use Gofabian\Negotiation\NegotiationMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tuupola\Middleware\Cors;

class MiddlewareProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function registerServices(): array
    {
        return [
            Cors::class => function (ContainerInterface $container) {
                return new Cors([
                    "logger" => $container->get('logger'),
                    "origin" => ["*"],
                    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
                    "headers.allow" => [],
                    "headers.expose" => [],
                    "cache" => 60,
                    "error" => function (ServerRequestInterface $request, ResponseInterface $response, $arguments) {
                        $data["status"] = "error";
                        $data["message"] = $arguments['message'];
                        return $response
                            ->withHeader("Content-Type", "application/json")
                            ->getBody()
                            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
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
     * @inheritDoc
     */
    public function registerServicesDevelopment(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function registerServicesTest(): array
    {
        return [];
    }
}
