<?php
namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class EntityExists
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class EntityExists extends Constraint
{
    public $service = 'app.validator.entity_exists';

    /**
     * @var string
     */
    public $class;

    /**
     * @var bool
     */
    public $nullable = false;

    /**
     * @var string
     */
    public $message = '%entity% does not exists.';

    public function getDefaultOption()
    {
        return 'class';
    }

    public function validatedBy()
    {
        return $this->service;
    }
}