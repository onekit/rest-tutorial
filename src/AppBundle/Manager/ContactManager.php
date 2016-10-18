<?php
namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Input\CreateContact;
use AppBundle\Repository\ContactRepository;
use AppBundle\Entity\Contact;

class ContactManager extends ApiManager
{

    /**
     * @var ContactRepository
     */
    protected $repo;

    private $adminEmail;

    protected $container;

    public function __construct(EntityManager $entityManager, $adminEmail, $container)
    {
        parent::__construct($entityManager);
        $this->container = $container;
    }

    protected function setRepository()
    {
        $this->repo = $this->em->getRepository('AppBundle:Contact');
    }


    public function mail(Contact $contact)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($contact->getEmail())
            ->setFrom($contact->getEmail())
            ->setTo($this->adminEmail)
            ->setBody(
                $this->container->get('templating')->render(
                    'AppBundle:Mail:contactMail.html.twig',
                    [
                        'email' => $contact->getEmail(),
                        'title' => $contact->getTitle(),
                        'body' => $contact->getBody(),
                        'details' => $contact->getDetails()
                    ]
                )
            );
        $this->container->get('mailer')->send($message);
        return $contact;
    }

    public function create(CreateContact $createContact)
    {
        $contact = new Contact();
        $contact->setTitle($createContact->title);
        $contact->setEmail($createContact->email);
        $contact->setWhen($createContact->when);
        $contact->setCity($createContact->city);
        $contact->setBody($createContact->body);
        $contact->setDetails($createContact->details);

        //$this->mail($contact); //send email on create new contact

        $this->em->persist($contact);
        $this->em->flush();
        return $contact;
    }


    public function update(Contact $contact, CreateContact $createContact)
    {
        $contact->setTitle($createContact->title);
        $contact->setEmail($createContact->email);
        $contact->setWhen($createContact->when);
        $contact->setCity($createContact->city);
        $contact->setBody($createContact->body);
        $contact->setDetails($createContact->details);
        $this->em->flush();
        return $contact;
    }

    public function getList()
    {
        $this->qb = $this->repo->getListQB();
        return $this;
    }

    public function order($column, $direction)
    {
        $this->qb->orderBy('c.'.$column, $direction);
        return $this;
    }
}