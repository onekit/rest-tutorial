<?php
namespace AppBundle\Factory;


use FOS\RestBundle\Controller\Annotations\QueryParam;

class ParamAnnotationFactory
{
    public static function getPageParam()
    {
        $param = new QueryParam();
        $param->name = 'page';
        $param->requirements = '\d+';
        $param->description = 'Page of the result';
        $param->default = 1;
        $param->allowBlank = false;
        return $param;
    }

    public static function getLimitParam($default)
    {
        $param = new QueryParam();
        $param->name = 'limit';
        $param->requirements = '\d+';
        $param->description = 'Item count limit';
        $param->default = intval($default);
        $param->allowBlank = false;
        return $param;
    }

    public static function getOrderByParam($columns)
    {
        $param = new QueryParam();
        $param->name = 'order';
        $param->key = 'orderBy';
        if (count($columns)) {
            $param->requirements = sprintf('(%s)', implode('|', $columns));
        }
        $param->default = reset($columns);
        $param->allowBlank = false;
        $param->description = 'order by';
        return $param;
    }

    public static function getOrderDirParam()
    {
        $param = new QueryParam();
        $param->name = 'direction';
        $param->key = 'orderDir';
        $param->requirements = '(ASC|DESC)';
        $param->default = 'ASC';
        $param->allowBlank = false;
        $param->description = 'order direction';
        return $param;
    }
}