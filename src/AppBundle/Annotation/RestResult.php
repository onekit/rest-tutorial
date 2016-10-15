<?php
namespace AppBundle\Annotation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * Class RestResult
 * @package AppBundle\Annotation
 *
 * @Annotation
 */
class RestResult extends ConfigurationAnnotation
{
    const STATUS_SUCCESS = 'Success';

    protected $status = 0;
    protected $message = self::STATUS_SUCCESS;
    protected $paginate = false;
    protected $sort = false;

    public function getStatus()
    {
        return $this->status;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getPaginate()
    {
        return $this->paginate;
    }

    public function getSort()
    {
        return is_array($this->sort) ? $this->sort : (is_string($this->sort) ? array($this->sort) : null);
    }

    public function setValue($value)
    {
        $this->setMessage($value);
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setPaginate($paginate)
    {
        $this->paginate = $paginate;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * Returns the alias name for an annotated configuration.
     *
     * @return string
     */
    public function getAliasName()
    {
        return 'RestResult';
    }

    /**
     * Returns whether multiple annotations of this type are allowed.
     *
     * @return bool
     */
    public function allowArray()
    {
        return false;
    }
}