<?php
namespace AppBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use AppBundle\Entity\User;

class UserPictureListener
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
        if ($entity instanceof User) {
            $entity = $this->updateImageUrl($entity);
            $args->getEntityManager()->flush($entity);
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof User) {
            $entity = $this->updateImageUrl($entity);
            $args->getEntityManager()->flush($entity);
        }
    }

    protected function updateImageUrl(User $user)
    {
        if (!is_null($user->getImagePath())) {
            $this->imagineCacheManager->remove($user->getImagePath());
            $user->setImageUrl($this->imagineCacheManager->getBrowserPath($user->getImagePath(), 'user_picture'));
        } else {
            $user->setImageUrl(sprintf('https://www.gravatar.com/avatar/%s?d=mm&s=51', md5($user->getEmail())));
        }
        return $user;
    }
}