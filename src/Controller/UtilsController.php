<?php

namespace USaq\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use USaq\App\Exception\ErrorInformation;
use USaq\Model\Exception\EntityNotFoundException;
use USaq\Templating\EngineInterface;

/**
 * Provides general operations as error list, retrieve server dates and others.
 */
class UtilsController
{
    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * UtilsController constructor.
     *
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Show list or errors or only one error.
     *
     * @param Response $response
     * @param int | null $identifier
     * @return Response|string
     * @throws EntityNotFoundException
     */
    public function showErrors(Response $response, $identifier = null)
    {
        if ($identifier !== null) {
            if (!isset(ErrorInformation::ERROR_CODES[$identifier])) {
                throw new EntityNotFoundException(sprintf('No error found with error_code %d', $identifier));
            }

            $dataToRender = [
                'resource' => ErrorInformation::ERROR_CODES[$identifier],
                'isItem' => true
            ];
        } else {
            $dataToRender = [
                'resource' => ErrorInformation::ERROR_CODES,
                'isCollection' => true
            ];
        }

        return $this->engine->render('USaq\Templating\Fractal\Transformers\ErrorTransformer', $dataToRender, $response);
    }
}
