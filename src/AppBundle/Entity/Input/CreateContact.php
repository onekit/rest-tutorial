<?php
namespace AppBundle\Entity\Input;


use JMS\Serializer\Annotation as Serial;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class CreateContact
 * @package AppBundle\Entity\Input
 *
 */
class CreateContact
{
    /**
     * @var string $email
     * @Serial\Type("string")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @var string $title
     * @Serial\Type("string")
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     */
    public $title;

    /**
     * @var \DateTime $when
     * @Serial\Type("DateTime")
     * @Assert\NotNull()
     * @Assert\DateTime()
     */
    public $when;

    /**
     * @var string $city
     * @Serial\Type("string")
     * @Assert\NotBlank()
     */
    public $city;

    /**
     * @var string $body
     * @Serial\Type("string")
     * @Assert\NotBlank()
     */
    public $body;

    /**
     * @var string $details
     * @Serial\Type("string")
     * @Assert\NotBlank()
     */
    public $details;
}