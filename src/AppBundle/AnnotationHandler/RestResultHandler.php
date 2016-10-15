<?php
namespace AppBundle\AnnotationHandler;


use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Nelmio\ApiDocBundle\Extractor\HandlerInterface;
use Nelmio\ApiDocBundle\Extractor\Handler\FosRestHandler;
use AppBundle\Annotation\RestResult;
use AppBundle\Factory\ParamAnnotationFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Route;

class RestResultHandler implements HandlerInterface
{
    /**
     * @var FosRestHandler
     */
    protected $fosRestHandler;

    public function __construct(FosRestHandler $fosRestHandler)
    {
        $this->fosRestHandler = $fosRestHandler;
    }

    /**
     * @inheritdoc
     */
    public function handle(ApiDoc $apiDoc, array $annotations, Route $route, \ReflectionMethod $method)
    {
        $forwardAnnotations = array();
        foreach ($annotations as $annotation) {
            if ($annotation instanceof RestResult) {
                if ($pagination = $annotation->getPaginate()) {
                    $forwardAnnotations[] = ParamAnnotationFactory::getPageParam();
                    $forwardAnnotations[] = ParamAnnotationFactory::getLimitParam(is_int($pagination) ? $pagination : 50);
                }
                ;
                if ($sortColumns = $annotation->getSort()) {
                    $param = ParamAnnotationFactory::getOrderByParam($sortColumns);
                    $param->name = $param->key;
                    $forwardAnnotations[] = $param;
                    $param = ParamAnnotationFactory::getOrderDirParam();
                    $param->name = $param->key;
                    $forwardAnnotations[] = $param;
                }
            }
        }
        if (count($forwardAnnotations)) {
            $this->fosRestHandler->handle($apiDoc, $forwardAnnotations, $route, $method);
        }
    }
}