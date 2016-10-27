<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Input\CreateUser;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Annotation\RestResult;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Entity\Output\Result;
use AppBundle\Form\Type\UserFormType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use FOS\UserBundle\Doctrine\UserManager as FOSUserManager;
use FOS\UserBundle\Util\UserManipulator;

class UserManager extends ApiManager
{
    /**
     * @var UserRepository
     */
    protected $repo;
    private $formFactory;
    private $requestStack;
    private $searchCriteria;

    /**
     * @var UserManipulator
     */
    protected $userManipulator;

    /**
     * @var FOSUserManager
     */
    protected $userManager;

    public function getRepository()
    {
        return $this->repo;
    }

    protected function setRepository()
    {
        $this->repo = $this->em->getRepository('AppBundle:User');
    }


    public function __construct(ObjectManager $em, FormFactory $formFactory, RequestStack $requestStack, UserManipulator $userManipulator, FOSUserManager $userManager)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
        $this->repo = $em->getRepository('AppBundle:User');
        $this->userManipulator = $userManipulator;
        $this->userManager = $userManager;

        /* criteria for query */
        $request = $this->requestStack->getCurrentRequest();
        if ($request) { //if launched not from CLI
            $this->searchCriteria['orderBy'] = $request->get('orderBy') ? $request->get('orderBy') : 'lastname';
            $this->searchCriteria['orderDir'] = $request->get('orderDir') ? $request->get('orderDir'):'ASC';
            $this->searchCriteria['page'] = $request->get('page') ? $request->get('page') : 1;
            $this->searchCriteria['limit'] = $request->get('limit') ? $request->get('limit') : 50;
            $this->searchCriteria['enabled'] = true; //TODO: discuss, would we allow to choose disabled users
        }

    }
    public function getList()
    {
        $this->qb = $this->repo->getListQB();

        return $this;
    }

    public function order($column, $direction)
    {
        $this->qb->orderBy('u.'.$column, $direction);
        return $this;
    }

    public function getEnabledUserById($id)
    {
        $data = $this->repo->getUserByIdQB($id, $this->searchCriteria)->getQuery()->getOneOrNullResult();
        return $this->handleResponseByData($data);
    }

    public function disabledUserById($id)
    {
        $user = $this->repo->getUserByIdQB($id, $this->searchCriteria)->getQuery()->getOneOrNullResult();
        if ($user) {
            $this->disable($user);
        }
        return $this->handleResponseByData($user);
    }

    public function createUser($user = null)
    {
        if (!$user) {
            $user = new User();
        }

        $form = $this->formFactory->create(new UserFormType(), $user);
        $form->handleRequest($this->requestStack->getCurrentRequest());
        if ($form->isValid()) {
            $this->update($user, true);
            return $this->handleResponseByData($user);
        } else {
            return new Result($form->getErrors(true, true), 'error', 1);
        }
    }

    public function loadById($id)
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function loadEnabledById($id)
    {
        return $this->repo->findOneBy(['id' => $id,'enabled'=> true]);
    }

    public function findUserByUsername($username)
    {
        return $this->repo->findOneBy(['username' => $username]);
    }

    /**
     * @param CreateUser $createUser
     * @return User
     */
    public function create(CreateUser $createUser)
    {
        /** @var User $user */
        $user = $this->userManipulator->create($createUser->username, $createUser->password, $createUser->email, true, $createUser->is_admin);
        $user->setLanguage($createUser->language);
        $this->userManager->updateUser($user);
        $this->userManager->reloadUser($user);
        return $user;
    }


    /**
     * @param User $user
     * @param CreateUser $createUser
     * @return User
     */
    public function updateUser(User $user, CreateUser $createUser)
    {
        $user->setUsername($createUser->username);
        $user->setEmail($createUser->email);
        $user->setPlainPassword($createUser->password);
        $user->setSuperAdmin($createUser->is_admin);
        $this->userManager->updateUser($user);
        return $user;
    }

    public function update(User $user, $flush = false)
    {
        $this->em->persist($user);
        if ($flush) {
            $this->em->flush();
        }
    }

    public function disable(User $user)
    {
        $user->setEnabled(false);
        $this->update($user,true);
    }

    private function handleResponseByData($data)
    {
        $status = 1;
        $message = 'Not Found';
        if ($data) {
            $status = 0;
            $message = RestResult::STATUS_SUCCESS;
        }

        return new Result($data, $message, $status);
    }
}

