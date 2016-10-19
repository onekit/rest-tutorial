<?php
namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Repository\ContactRepository;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Input\CreateContact;
use AppBundle\Entity\Input\ContactPicture;
use Symfony\Component\Filesystem\Filesystem;

class ContactManager extends ApiManager
{

    /**
     * @var ContactRepository
     */
    protected $repo;

    private $adminEmail;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment
     */
    protected $templating;

    /**
     * @var string
     */
    protected $mediaPath;

    public function __construct(EntityManager $entityManager, $adminEmail, \Swift_Mailer $mailer, $mediaPath, \Twig_Environment $templating)
    {
        parent::__construct($entityManager);
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
        $this->mediaPath = realpath($mediaPath);
        $this->templating = $templating;

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
                $this->templating->render(
                    'AppBundle:Mail:contactMail.html.twig',
                    [
                        'email' => $contact->getEmail(),
                        'title' => $contact->getTitle(),
                        'body' => $contact->getBody(),
                        'details' => $contact->getDetails()
                    ]
                )
            );
        $this->mailer->send($message);
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

    public function setPicture(Contact $contact, ContactPicture $picture = null)
    {
        if (!is_null($picture)) {
            $image = $picture->image;
            $fs = new Filesystem();
            $fullPath = sprintf('%s/contactimage-%u.%s', $this->mediaPath, $contact->getId(), $image->guessExtension());
            $fs->copy($image->getRealPath(), $fullPath, true);
            $contact->setImagePath(rtrim($fs->makePathRelative($fullPath, $this->mediaPath), '/'));
        } else {
            $contact->setImagePath(null);
        }

        $this->update($contact, $picture);
        return $contact;
    }

}