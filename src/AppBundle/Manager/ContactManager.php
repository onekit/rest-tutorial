<?php
namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Repository\ContactRepository;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Input\CreateContact;
use AppBundle\Entity\Input\ContactPicture;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

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
     * @var CacheManager
     */
    protected $imagineCacheManager;

    /**
     * @var UploaderHelper
     */
    protected $uploaderHelper;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    public function __construct(EntityManager $entityManager, $adminEmail, \Swift_Mailer $mailer, \Twig_Environment $templating, CacheManager $cacheManager, UploaderHelper $uploaderHelper, RequestStack $requestStack)
    {
        parent::__construct($entityManager);
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->imagineCacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
        $this->requestStack = $requestStack;
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

        //send email to admin about creation new contact
        //$this->mail($contact);

        $this->em->persist($contact);
        $this->em->flush();
        return $contact;
    }


    /**
     * @param Contact $contact
     * @param CreateContact $createContact|null
     * @return Contact
     */
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

    /**
     * @param Contact $contact
     * @return Contact
     */
    public function updateContact(Contact $contact)
    {
        $this->em->persist($contact);
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
        $imageFile = !is_null($picture) ? $picture->image : null;
        $baseURI = null;
        $contact->setImage($imageFile);
        $this->updateContact($contact);

        if ($imageFile) {
            $picturePath = $this->uploaderHelper->asset($contact, 'image');
            $baseURI = $this->imagineCacheManager->generateUrl($picturePath, 'contact_picture');
        }
        $contact->setImageUrl($baseURI);
        $this->updateContact($contact);

        return $contact;
    }

}