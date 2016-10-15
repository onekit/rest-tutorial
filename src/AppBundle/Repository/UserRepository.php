<?php
namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getListQB()
    {
        $qb = $this->createQueryBuilder('u');
        return $qb;
    }
}