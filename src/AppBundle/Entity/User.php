<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serial;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @DoctrineAssert\UniqueEntity("email")
 * @DoctrineAssert\UniqueEntity("username")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(
 *      name = "mailer_user",
 *      indexes = {
 *          @ORM\Index(name="created_idx", columns={"created"})
 *      }
 * )
 */
class User extends BaseUser
{

    const LANG_EN = 'en';
    const LANG_DE = 'de';


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serial\Groups({"default", "contact", "profile"})
     */
    protected $id;

    /**
     * @var string $language
     * @ORM\Column(name="language", type="string", length=2)
     *
     * @Assert\Choice(callback = "getLanguages")
     * @Assert\NotNull()
     * @Serial\Groups({"user", "profile"})
     */
    protected $language = self::LANG_DE;

    /**
     * @var \DateTime $created
     * @ORM\Column(name="created", type="datetime", nullable=false)
     * @Serial\Groups({"user"})
     */
    protected $created;


    /**
     * @Serial\VirtualProperty()
     * @Serial\SerializedName("username")
     * @Serial\Groups({"default", "user"})
     * @return string
     */
    public function getVirtualUsername()
    {
        return $this->getUsername();
    }

    /**
     * @Serial\VirtualProperty()
     * @Serial\SerializedName("email")
     * @Serial\Groups({"user"})
     * @return string
     */
    public function getVirtualEmail()
    {
        return $this->getEmail();
    }


    /**
     * @return string[]
     */
    public static function getLanguages()
    {
        return array(
            self::LANG_EN,
            self::LANG_DE,
        );
    }


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * Set language
     *
     * @param string $language
     *
     * @return User
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }


    /**
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->created = new \DateTime();
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

}
