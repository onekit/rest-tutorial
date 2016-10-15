<?php
namespace AppBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTCreatedListener
{
  public function onJWTCreated(JWTCreatedEvent $event)
  {
    if (!$request = $event->getRequest()) {
      return;
    }

    $payload = $event->getData();
    $payload['id'] = $event->getUser()->getId();
    $event->setData($payload);
  }
}
