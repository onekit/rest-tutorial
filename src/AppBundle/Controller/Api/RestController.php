<?php
namespace AppBundle\Controller\Api;


use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Output\Result;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RestController
 * @package AppBundle\Controller\Api
 *
 */
abstract class RestController extends FOSRestController
{
    public function errorAction($message, $data, $status)
    {
        $result = new Result($data, $message, $status);
        return $this->view($result, 400);
    }

    public function handleError($message, $data = array(), $status = 400)
    {
        /** @var Request $request */
        $request = $this->get('request');
        list($controller, $action) = explode("::", $request->attributes->get('_controller'));
        return $this->forward(sprintf('%s::errorAction', $controller), array(
            'message' => $message,
            'data' => $data,
            'status' => $status,
        ));
    }
}