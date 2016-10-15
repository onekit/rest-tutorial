<?php
namespace AppBundle\EventListener;


use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use AppBundle\Annotation\RestResult;
use AppBundle\Factory\ParamAnnotationFactory;
use AppBundle\Entity\Output\Result;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class RestListener
{

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var int
     */
    protected $defaultLimit = 50;

    public function __construct(Reader $reader, ParamFetcher $paramFetcher)
    {
        $this->reader = $reader;
        $this->paramFetcher = $paramFetcher;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }
        $className = class_exists('Doctrine\Common\Util\ClassUtils') ? ClassUtils::getClass($controller[0]) : get_class($controller[0]);
        $object = new \ReflectionClass($className);
        $method = $object->getMethod($controller[1]);

        $restAnnotation = false;
        $methodAnnotations = $this->reader->getMethodAnnotations($method);
        foreach ($methodAnnotations as $annotation) {
            if ($annotation instanceof RestResult) {
                $restAnnotation = $annotation;
            }
        }
        if (!$restAnnotation) {
            $classAnnotations = $this->reader->getClassAnnotations($object);
            foreach ($classAnnotations as $annotation) {
                if ($annotation instanceof RestResult) {
                    $restAnnotation = $annotation;
                }
            }
        }
        if (!$restAnnotation) {
            return;
        }
        if ($restAnnotation->getPaginate() || $restAnnotation->getSort()) {
            $controller = $event->getController();
            if (is_callable($controller) && method_exists($controller, '__invoke')) {
                $controller = array($controller, '__invoke');
            }
            $this->paramFetcher->setController($controller);

            if ($pagination = $restAnnotation->getPaginate()) {
                $this->paramFetcher->addParam(ParamAnnotationFactory::getPageParam());
                $this->paramFetcher->addParam(ParamAnnotationFactory::getLimitParam(is_int($pagination) ? $pagination : 50));
            }
            if (is_array($sort = $restAnnotation->getSort())) {
                $this->paramFetcher->addParam(ParamAnnotationFactory::getOrderByParam($sort));
                $this->paramFetcher->addParam(ParamAnnotationFactory::getOrderDirParam());
            }
        }
        $event->getRequest()->attributes->set('_rest_result', $restAnnotation);
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        /** @var RestResult|null $restAnnotation */
        $restAnnotation = $event->getRequest()->attributes->get('_rest_result');
        if (!$restAnnotation) {
            return;
        }
        $result = $event->getControllerResult();
        if ($result instanceof Result) {
            return;
        }
        if ($result instanceof View) {
            return;
        }
        $result = new Result($result, $restAnnotation->getMessage(), $restAnnotation->getStatus());
        $event->setControllerResult($result);
    }
}