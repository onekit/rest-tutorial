<?php
namespace AppBundle\Entity\Input;
use JMS\Serializer\Annotation as Serial;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;


/**
 * Class CreateContact
 * @package AppBundle\Entity\Input
 *
 */
class CreateContact
{
    /**
     * @var string $email
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(min=2, max=255)
     * @Serial\Type("string")
     */
    public $email;

    /**
     * @var string $title
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     * @Serial\Type("string")
     */
    public $title;


    /**
     * @var \DateTime $when
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @Serial\Type("DateTime")
     */
    public $when;

    /**
     * @var string $city
     * @Assert\NotBlank()
     * @Serial\Type("string")
     */
    public $city;

    /**
     * @var string $body
     * @Assert\NotBlank()
     * @Serial\Type("string")
     */
    public $body;

    /**
     * @var string $details
     * @Assert\NotBlank()
     * @Serial\Type("string")
     */
    public $details;

    /**
     * @var File $image
     * @Serial\Type("Symfony\Component\HttpFoundation\File\File")
     */
    public $image;

}