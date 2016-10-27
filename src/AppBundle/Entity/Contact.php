<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use JMS\Serializer\Annotation as Serial;

/**
 * Contact
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 * @ORM\Table(name="rest_contacts")
 * @Vich\Uploadable
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
     * @ORM\Column(name="when_datetime", type="datetime", nullable=false)
     * @Serial\SerializedName("when")
     * @Serial\Groups({"default", "contact"})
     * @Serial\Type("DateTime")
     */
    protected $when;

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
     * @Vich\UploadableField(mapping="contact_image", fileNameProperty="imagePath")
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
     * @Serial\Groups({"contact_picture"})
     */
    protected $imageUrl;

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
     * @return \DateTime
     */
    public function setWhen($when)
    {
        $this->when = $when;
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
