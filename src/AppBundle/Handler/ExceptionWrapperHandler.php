<?php
namespace AppBundle\Handler;


use FOS\RestBundle\View\ExceptionWrapperHandlerInterface;
use Symfony\Component\Debug\Exception\FlattenException;

class ExceptionWrapperHandler implements ExceptionWrapperHandlerInterface
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
