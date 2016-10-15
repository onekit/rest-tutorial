<?php
namespace AppBundle\Handler;


use AppBundle\Entity\Output\Result;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class AuthHandler implements LogoutSuccessHandlerInterface
{
    public function onLogoutSuccess(Request $request)
    {
        $result = new Result();
        return new JsonResponse($result);
    }
}