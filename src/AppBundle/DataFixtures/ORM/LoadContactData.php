<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Manager\ContactManager;
use AppBundle\Entity\Input\CreateContact;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadContactData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContactManager
     */
    protected $contactManager;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->contactManager = $container->get('api.manager.contact');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // contact
        $this->createContact('onekit@gmail.com', 'Aliaksandr Harbunou', '1980-07-25T10:00:00', 'Vitebsk','Text of message', 'Sent');

    }

    protected function createContact($email, $title, $when, $city, $body, $details)
    {
        $createContact = new CreateContact();
        $createContact->email = $email;
        $createContact->title = $title;
        $createContact->when = new \DateTime($when);
        $createContact->city = $city;
        $createContact->body = $body;
        $createContact->details = $details;
        $contact = $this->contactManager->create($createContact);
        return $contact;
    }
}