<?php
namespace AppBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use AppBundle\Entity\Contact;

class ContactPictureListener
{
    /**
     * @var CacheManager
     */
    protected $imagineCacheManager;

    public function __construct(CacheManager $cacheManager)
    {
        $this->imagineCacheManager = $cacheManager;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Contact) {
            $entity = $this->updateImageUrl($entity);
            $args->getEntityManager()->flush($entity);
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Contact) {
            $entity = $this->updateImageUrl($entity);
            $args->getEntityManager()->flush($entity);
        }
    }

    protected function updateImageUrl(Contact $contact)
    {
        if (!is_null($contact->getImagePath())) {
            $this->imagineCacheManager->remove($contact->getImagePath());
            $contact->setImageUrl($this->imagineCacheManager->getBrowserPath($contact->getImagePath(), 'contact_picture'));
        } else {
            $contact->setImageUrl(sprintf('https://www.gravatar.com/avatar/%s?d=mm&s=51', md5($contact->getEmail())));
        }
        return $contact;
    }
}