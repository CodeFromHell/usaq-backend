<?php

namespace USaq\Service;

use Doctrine\ORM\EntityManager;

class AuthenticationService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}