<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * API Auth controller.++
 */
class AuthController extends FOSRestController
{
    /**
     * @Rest\Get("/login", name = "api_login")
     */
    public function loginAction()
    {

    }

    /**
     * @ApiDoc(
     *      parameters = {
     *          {"name" = "_username", "dataType"="string", "required"=true, "description"="user login"},
     *          {"name" = "_password", "dataType"="string", "required"=true, "description"="user password"},
     *      },
     *      views = {"default", "admin"}
     * )
     *
     * @Rest\Post("/login_check", name = "api_login_check")
     */
    public function loginCheckAction()
    {

    }

    /**
     * @ApiDoc
     *
     * @Rest\Get("/logout", name = "api_logout")
     *
     * @return bool
     */
    public function logoutAction()
    {
        return true;
    }
}