<?php

namespace USaq\Templating\Fractal\Transformers;

use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use USaq\Model\Entity\Token;

class TokenTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user'
    ];

    public function transform(Token $token) {
        return [
            'token' => $token->getTokenString()
        ];
    }

    public function includeUser(Token $token)
    {
        return $this->item($token->getUser(), new UserTransformer());
    }
}