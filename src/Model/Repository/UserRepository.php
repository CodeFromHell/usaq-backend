<?php

namespace USaq\Model\Repository;

use Doctrine\ORM\EntityRepository;
use USaq\Model\Entity\User;

class UserRepository extends EntityRepository
{
    /**
     * Returns all users that are not one of those passed.
     *
     * @param int[] $userIds
     * @return User[]
     */
    public function getAllExcept(array $userIds): array
    {
        $builder = $this->createQueryBuilder('u');
        $builder->where($builder->expr()->notIn('u.id', $userIds));

        return $builder->getQuery()->getResult();
    }
}
