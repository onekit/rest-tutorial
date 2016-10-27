<?php
namespace AppBundle\Entity\Input;


use JMS\Serializer\Annotation as Serial;
use AppBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Class CreateUser
 * @package AppBundle\Rest\Input
 *
 * @DoctrineAssert\UniqueEntity("username", service="app.validator.unique_user")
 * @DoctrineAssert\UniqueEntity("email", service="app.validator.unique_user")
 */
class CreateUser
{
    /**
     * @var string $username
     *
     * @Assert\Length(min=3)
     * @Assert\NotNull()
     * @Assert\Length(min=2, max=255)
     * @Serial\Type("string")
     */
    public $username;

    /**
     * @var string $email
     *
     * @Assert\Email()
     * @Assert\NotNull()
     * @Serial\Type("string")
     */
    public $email;

    /**
     * @var string $email
     *
     * @Assert\Length(min=6)
     * @Assert\NotNull()
     * @Serial\Type("string")
     */
    public $password;

    /**
     * @var string $language
     *
     * @Assert\Choice(callback = {"\AppBundle\Entity\User", "getLanguages"})
     * @Serial\Type("string")
     */
    public $language = User::LANG_DE;

    /**
     * @var boolean $is_admin
     *
     * @Assert\NotNull()
     * @Serial\Type("boolean")
     */
    public $is_admin;
}