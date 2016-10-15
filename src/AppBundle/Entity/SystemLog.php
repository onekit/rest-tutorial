<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints\DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="mailer_system_log")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SystemLogRepository")
 */
class SystemLog
{
    const USER_SENT_MESSAGE = 'user-sent-message';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var datetime $created
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var string $action
     * @ORM\Column(name="action", nullable=false)
     */
    protected $action;

    /**
     * @var string $ip
     * @ORM\Column(name="ip", nullable=true)
     */
    protected $ip;


    public function __construct($ip = null, $action = null, $targetId = null)
    {
        $this->setIp($ip);
        $this->setAction($action);
        $this->setCreated(new \DateTime());
    }

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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return SystemLog
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
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
     * Set action
     *
     * @param string $action
     *
     * @return SystemLog
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }


    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return SystemLog
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

}
