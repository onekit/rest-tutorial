<?php
namespace AppBundle\Manager;

use AppBundle\Entity\Input\CreateContact;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Contact;

class ContactManager
{
    private $om;

    function __construct(ObjectManager $om)
    {
        $this->om = $om;
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
        $this->om->persist($contact);
        $this->om->flush();
        return $contact;
    }

    public function update(Contact $contact, $flush = false)
    {
        $this->om->persist($contact);
        if ($flush) {
            $this->om->flush();
        }
    }

    public function delete(Contact $contact)
    {
        $this->om->remove($contact);
        $this->om->flush();
    }

}