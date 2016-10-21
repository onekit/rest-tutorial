<?php
namespace AppBundle\Serializer;

use JMS\Serializer\GenericDeserializationVisitor;

/**
 * Class FormDeserializationVisitor
 * @package AppBundle\Serializer
 */
Class FormDeserializationVisitor extends GenericDeserializationVisitor
{
    /**
     * @param $str
     * @return array
     */
    protected function decode($str)
    {
        parse_str($str, $output);

        return $output;
    }
}