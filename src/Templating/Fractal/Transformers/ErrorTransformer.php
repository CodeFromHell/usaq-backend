<?php

namespace USaq\Templating\Fractal\Transformers;

use League\Fractal\TransformerAbstract;

class ErrorTransformer extends TransformerAbstract
{
    public function transform(array $error)
    {
        return [
            'error_code' => $error['error_code'],
            'description' => $error['description']
        ];
    }
}
