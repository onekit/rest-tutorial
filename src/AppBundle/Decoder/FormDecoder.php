<?php
namespace AppBundle\Decoder;


use FOS\RestBundle\Decoder\DecoderInterface;

class FormDecoder implements DecoderInterface
{
    /**
     * {@inheritdoc}
     */
    public function decode($data)
    {
        parse_str($data, $result);
        return $result;
    }
}
