<?php

namespace USaq\Templating\Fractal\Transformers;

use League\Fractal\TransformerAbstract;
use USaq\Model\Entity\User;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'nickname' => $user->getNickname()
        ];
    }
}