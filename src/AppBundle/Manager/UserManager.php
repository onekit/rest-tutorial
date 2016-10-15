<?php

namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Annotation\RestResult;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserFormType;
use AppBundle\Repository\UserRepository;
use AppBundle\Entity\Output\Result;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;

class UserManager
{
    /**
     * @var UserRepository
     */
    private $repo;
    private $formFactory;
    private $requestStack;
    private $searchCriteria;

    public function getRepository()
    {
        return $this->repo;
    }


    public function __construct(ObjectManager $em, FormFactory $formFactory, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
        $this->repo = $em->getRepository('AppBundle:User');

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

    public function getUserList()
    {
        $data = $this->repo->getUserListQB($this->searchCriteria)->getQuery()->getResult();
        return $this->handleResponseByData($data);
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

    public function update(User $user, $flush = false)
    {
        $this->em->persist($user);
        if ($flush) {
            $this->em->flush();
        }
    }

    public function delete(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function disable(User $user)
    {
        $user->setEnabled(false);
        $this->update($user,true);
    }

    public function autocomplete($keyword, $page, $limit)
    {
        return $this->repo->autocompleteQB($keyword, $page, $limit)->getQuery()->getResult();
    }

    public function doctorAutocomplete($keyword, $page, $limit)
    {
        return $this->repo->doctorAutocompleteQB($keyword, $page, $limit)->getQuery()->getResult();
    }

    public function doctorAssistantAutocomplete($keyword, $page, $limit, $user)
    {
        return $this->repo->doctorAssistantAutocompleteQB($keyword, $page, $limit, $user)->getQuery()->getResult();
    }

    public function adminAutocomplete($keyword, $page, $limit)
    {
        return $this->repo->adminAutocompleteQB($keyword, $page, $limit)->getQuery()->getResult();
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

