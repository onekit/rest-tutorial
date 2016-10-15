<?php
namespace AppBundle\Serializer;


use JMS\Serializer\GenericDeserializationVisitor;
use JMS\Serializer\Naming\PropertyNamingStrategyInterface;
use AppBundle\Decoder\FormDecoder;

class FormDeserializationVisitor extends GenericDeserializationVisitor
{
    /**
     * @var FormDecoder
     */
    protected $decoder;

    public function __construct(PropertyNamingStrategyInterface $namingStrategy, FormDecoder $decoder)
    {
        parent::__construct($namingStrategy);
        $this->decoder = $decoder;
    }

    protected function decode($str)
    {
        return $this->decoder->decode($str);
    }
}