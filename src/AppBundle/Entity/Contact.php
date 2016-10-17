<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use JMS\Serializer\Annotation as Serial;
use Fresh\VichUploaderSerializationBundle\Annotation as Fresh;

/**
 * Contact
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 * @ORM\Table(name="mailer_contacts")
 * @Vich\Uploadable
 * @Fresh\VichSerializableClass
 */
class Contact
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serial\SerializedName("id")
     * @Serial\Groups({"default"})
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255)
     * @Serial\SerializedName("email")
     * @Serial\Groups({"default"})
     */
    protected $email;

    /**
     * @var string $title
     * @ORM\Column(name="title", type="string", length=255)
     * @Serial\SerializedName("title")
     * @Serial\Groups({"default"})
     * @Serial\Type("string")
     */
    public $title;

    /**
     * @var \DateTime $when
     *
     * @ORM\Column(name="when", type="datetime", nullable=false)
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @Serial\SerializedName("when")
     * @Serial\Groups({"default"})
     * @Serial\Type("DateTime")
     */
    public $when;

    /**
     * @var string $city
     * @ORM\Column(name="city", type="string", length=255)
     * @Serial\Groups({"default"})
     * @Serial\Type("string")
     */
    public $city;

    /**
     * @var string $body
     * @ORM\Column(name="body", type="text")
     * @Serial\Groups({"default"})
     * @Serial\Type("string")
     */
    public $body;

    /**
     * @var string $details
     * @ORM\Column(name="details", type="text")
     * @Serial\Groups({"default"})
     * @Serial\Type("string")
     */
    public $details;

    /**
     * @var string
     *
     * @var string $imagePath
     * @ORM\Column(name="image_name", type="string", length=255, nullable=true)
     * @Serial\Expose
     * @Serial\SerializedName("image")
     *
     * @Fresh\VichSerializableField("imageFile")
     */
    protected $imageName;

    /**
     * @Serial\Exclude
     * @Vich\UploadableField(mapping="image_mapping", fileNameProperty="imageName")
     * @var File $imageFile
     */
    public $imageFile;




    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }




    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param string $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return \DateTime
     */
    public function getWhen()
    {
        return $this->when;
    }

    /**
     * @param \DateTime $when
     */
    public function setWhen($when)
    {
        $this->when = $when;
    }


}
