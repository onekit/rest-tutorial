<?php
namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\SystemLog;
use AppBundle\Entity\Contact;

class ContactManager
{
    private $om;

    function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function update(SystemLog $systemLog, $flush = false)
    {
        $this->om->persist($systemLog);
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