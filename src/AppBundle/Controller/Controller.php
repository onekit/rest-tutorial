<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Doctrine\ORM\EntityRepository;

class Controller extends BaseController
{
    const RESULTS_PER_PAGE = 10;

    protected function getUserManager()
    {
        return $this->container->get('manager.user');
    }

    protected function getRepository($entity)
    {
        return $this->getEntityManager()->getRepository(is_object($entity) ? get_class($entity) : $entity);
    }

    protected function isGranted($attributes, $object = null)
    {
        return $this->getSecurity()->isGranted($attributes, $object);
    }

    protected function persist($entity, $flush = false)
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->flush($entity);
        }
    }

    protected function remove($entity, $flush = false)
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->flush($entity);
        }
    }

    protected function translate($id, array $parameters = array(), $domain = null, $locale = null)
    {
        $translator = $this->get('translator');
        return $translator->trans($id, $parameters, $domain, $locale);
    }

    protected function flush($entity = null)
    {
        $this->getEntityManager()->flush($entity);
    }

    protected function findOr404($entity, $criteria = array())
    {
        $result = null;

        if (is_object($entity) && $entity instanceof EntityRepository) {
            if (is_array($criteria)) {
                $result = $entity->findOneBy($criteria);
            } else {
                $result = $entity->find($criteria);
            }
        } elseif (is_object($entity) && $this->getEntityManager()->contains($entity)) {
            $result = $this->getEntityManager()->refresh($entity);
        } elseif (is_string($entity)) {
            $repository = $this->getRepository($entity);
            if (is_array($criteria)) {
                $result = $repository->findOneBy($criteria);
            } else {
                $result = $repository->find($criteria);
            }
        }

        if (null !== $result) {
            return $result;
        }

        throw $this->createNotFoundException('Resource not found');
    }

    protected function getSession()
    {
        return $this->get('session');
    }

    protected function getMailer()
    {
        return $this->get('mailer');
    }

    protected function getSecurity()
    {
        return $this->get('security.context');
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return FlashBag
     */
    protected function getFlashBag()
    {
        return $this->getSession()->getFlashBag();
    }

    protected function getParameter($name)
    {
        return $this->container->getParameter($name);
    }
}
