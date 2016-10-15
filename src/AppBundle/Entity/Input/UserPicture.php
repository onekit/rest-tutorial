<?php
namespace AppBundle\Entity\Input;


use JMS\Serializer\Annotation as Serial;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;

class UserPicture
{
    /**
     * @var File $image
     *
     * @Assert\Image
     * @Assert\NotNull
     */
    public $image;
}