<?php
namespace AppBundle\Handler;


use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\Debug\Exception\FlattenException;

class ViewHandler implements ViewHandlerInterface
{
    public function wrap($data)
    {
        /** @var FlattenException $exception */
        $exception = $data['exception'];
        return array(
            'status' => $exception->getStatusCode(),
            'message' => $exception->getMessage(),
        );
    }
}
