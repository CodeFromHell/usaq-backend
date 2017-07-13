<?php

namespace USaq\Templating\Fractal;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Psr\Http\Message\ResponseInterface;
use USaq\Templating\EngineInterface;
use USaq\Templating\Exception\TemplateEngineException;

/**
 * Provides a view layer to show information as JSON.
 *
 * When using {@see FractalEngine::render}, parameter $data is an array with the following signature:
 * - 'resource' => Resource to be rendered.
 * - 'include' => Data to be include from the available includes defined in the template.
 * - 'exclude' => Data to be exclude from the default includes defined in the template.
 * - 'meta' => Data to be included as metadata.
 */
class FractalEngine implements EngineInterface
{
    /**
     * @var Manager
     */
    private $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritdoc
     */
    public function supports($template): bool
    {
        return is_subclass_of($template, TransformerAbstract::class);
    }

    /**
     * @inheritdoc
     */
    public function exists($template): bool
    {
        return class_exists($template);
    }

    /**
     * @inheritdoc
     */
    public function render($template, array $data, ResponseInterface $response = null)
    {
        $this->validateDataToRender($data);

        if (!$this->exists($template)) {
            throw new TemplateEngineException('Template not exists');
        }

        if (!$this->supports($template)) {
            throw new TemplateEngineException('This type of template is not supported');
        }

        // Prepare manager to process data
        $this->prepareManager($data);

        $resource = $this->createResource($template, $data);

        if ($response) {
            $response->getBody()->write($resource->toJson());
            return $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        } else {
            return $resource->toJson();
        }
    }

    /**
     * Check that data to be rendered is correct.
     *
     * @param $data
     * @throws TemplateEngineException      If data is incorrect or don't have all required parameters to work.
     */
    private function validateDataToRender(array $data)
    {
        if (!isset($data['resource'])) {
            throw new TemplateEngineException('Data to be rendered must be an array with at least "resource" key');
        }
    }

    private function prepareManager(array $data): void
    {
        if (isset($data['include'])) {
            $this->manager->parseIncludes($data['include']);
        }

        if (isset($data['exclude'])) {
            $this->manager->parseExcludes($data['exclude']);
        }
    }

    /**
     * @param $template
     * @param array $data
     * @return \League\Fractal\Scope
     */
    private function createResource($template, array $data)
    {
        if (is_array($data['resource'])) {
            $resource = new Collection($data['resource'], new $template());
        } else {
            $resource = new Item($data['resource'], new $template());
        }

        if (isset($data['meta']) && is_array($data['meta'])) {
            $metadata = array_merge($resource->getMeta(), $data['meta']);
            $resource->setMeta($metadata);
        }

        return $this->manager->createData($resource);
    }
}
