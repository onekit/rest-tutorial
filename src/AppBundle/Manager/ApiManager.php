<?php
namespace AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract class ApiManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repo;

    /**
     * @var QueryBuilder
     */
    protected $qb;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->setRepository();
    }

    abstract protected function setRepository();

    abstract public function getList();

    public function QB()
    {
        return $this->qb;
    }

    /**
     * @param $id
     * @return null|object
     */
    public function get($id)
    {
        return $this->repo->find($id);
    }

    public function reload($entity)
    {
        $this->em->refresh($entity);
        return $entity;
    }

    public function delete($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * @param string $column
     * @param string $direction
     * @return $this
     */
    abstract public function order($column, $direction);

    /**
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function paginate($page, $limit)
    {
        $this->qb->setMaxResults($limit)->setFirstResult(($page - 1) * $limit);
        return $this->all();
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->qb->getQuery()->getResult();
    }
}