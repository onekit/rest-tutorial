<?php
namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository
{
    public function getListQB()
    {
        $qb = $this->createQueryBuilder('c');
        return $qb;
    }
}