<?php

namespace USaq\Templating;

use Psr\Http\Message\ResponseInterface;

/**
 * Provide methods to render information to be returned to the user.
 *
 * Any templating engine to be used in the system must implement this interface.
 */
interface EngineInterface
{
    /**
     * Check if engine support this template.
     *
     * @param $template
     * @return bool
     */
    public function supports($template): bool;

    /**
     * Check if template exists.
     *
     * @param $template
     * @return bool
     */
    public function exists($template): bool;

    /**
     * Render template.
     *
     * @param string $template                  Template.
     * @param array $data                       Data to be rendered.
     * @param ResponseInterface|null $response  If response is passed, render template in Response body an return it.
     * @return string | ResponseInterface
     */
    public function render($template, array $data, ResponseInterface $response = null);
}
