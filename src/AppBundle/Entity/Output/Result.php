<?php
namespace AppBundle\Entity\Output;


use AppBundle\Annotation\RestResult;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Result
 * @package AppBundle\Rest
 */
class Result
{
    /**
     * @JMS\Groups({"profile", "default"})
     */
    public $status;

    /**
     * @JMS\Groups({"profile", "default"})
     */
    public $message;

    /**
     * @JMS\Groups({"profile", "default"})
     */
    public $data;

    public function __construct($data = null, $message = RestResult::STATUS_SUCCESS, $status = 0)
    {
        if (!is_null($data)) {
            $this->data = $data;
        }
        $this->message = $message;
        $this->status = $status;
    }
}