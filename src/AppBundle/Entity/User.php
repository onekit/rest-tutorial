<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serial;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

use Symfony\Component\HttpFoundation\File\File;
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
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SystemLog", mappedBy="user", cascade={"all"})
     */
    protected $systemLogs;

    /**
     * @Vich\UploadableField(mapping="user_picture", fileNameProperty="imagePath")
     *
     * @var File
     */
    public $image;

    /**
     * @var string
     *
     * @var string $imagePath
     * @ORM\Column(name="image_path", type="string", length=64, nullable=true)
     */
    protected $imagePath;

    /**
     * @var string
     *
     * @var string $imagePath
     * @ORM\Column(name="image_url", type="string", length=255, nullable=true)
     * @Serial\SerializedName("image")
     * @Serial\Groups({"user_picture"})
     */
    protected $imageUrl;

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


    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->isExpired();
    }

    public function __construct()
    {
        parent::__construct();
        $this->systemLogs = new ArrayCollection();
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

    /**
     * Add systemLog
     *
     * @param \AppBundle\Entity\SystemLog $systemLog
     *
     * @return User
     */
    public function addSystemLog(\AppBundle\Entity\SystemLog $systemLog)
    {
        $this->systemLogs[] = $systemLog;

        return $this;
    }

    /**
     * Remove systemLog
     *
     * @param \AppBundle\Entity\SystemLog $systemLog
     */
    public function removeSystemLogsSent(\AppBundle\Entity\SystemLog $systemLog)
    {
        $this->systemLogs->removeElement($systemLog);
    }

    /**
     * Get systemLogsSent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSystemLogsSent()
    {
        return $this->systemLogs;
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     * @return $this
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     * @return $this
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

}
