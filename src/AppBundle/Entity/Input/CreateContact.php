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
     *
     * @Assert\Email()
     * @Assert\Length(min=2, max=255)
     * @Serial\Type("string")
     */
    public $email;

    /**
     * @var string $title
     *
     * @Assert\Length(min=2)
     * @Serial\Type("string")
     */
    public $title;

    /**
     * @var \DateTime $when
     * @Assert\NotNull()
     * @Serial\Type("DateTime")
     */
    public $when;

    /**
     * @var string $city
     *
     * @Assert\Length(min=2)
     * @Serial\Type("string")
     */
    public $city;

    /**
     * @var string $body
     *
     * @Assert\Length(min=2)
     * @Serial\Type("string")
     */
    public $body;

    /**
     * @var string $details
     *
     * @Assert\Length(min=2)
     * @Serial\Type("string")
     */
    public $details;

    /**
     * @var File $imageFile
     */
    public $image;

}