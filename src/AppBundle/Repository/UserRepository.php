<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

class UserRepository extends EntityRepository
{
    public function getListQB()
    {
        $qb = $this->createQueryBuilder('u');
        return $qb;
    }

    public function getUserListQB($criteria)
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.enabled = :enabled');
        $qb->setParameter('enabled', $criteria['enabled'])
          ->setMaxResults($criteria['limit'])
          ->setFirstResult(($criteria['page'] - 1) * $criteria['limit'])
          ->orderBy("u.".$criteria['orderBy'],$criteria['orderDir']);

        return $qb;
    }

    public function getUserByIdQB($id, $criteria)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.id, u.username, u.lastname')
            ->where('u.id = :id')
            ->andWhere('u.enabled = :enabled')
            ->setParameter('id', $id)
            ->setParameter('enabled', $criteria['enabled']);

        return $qb;
    }

    public function search($query)
    {
        $qb = $this->createQueryBuilder('u');
        if ($query = trim($query)) {
            $qb->andWhere('u.lastname LIKE :query');
            $qb->setParameter('query', '%' . $query . '%');
        }
        $qb->orderBy("u.created", "desc");
        return $qb;
    }

}
