<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadUserData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var UserManipulator
     */
    protected $userManipulator;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->userManipulator = $container->get('fos_user.util.user_manipulator');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // admins
        $this->createUser('admin', 'admin', 'admin', 'onekit@gmail.com', true);

    }

    protected function createUser($referenceName, $username, $password, $email, $isAdmin = false)
    {
        $user = $this->userManipulator->create($username, $password, $email, true, $isAdmin);
        if (trim($referenceName)) {
            $this->setReference(sprintf('user:%s', trim($referenceName)), $user);
        }
        return $user;
    }
}