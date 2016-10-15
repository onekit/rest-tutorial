<?php
namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueId
 * @package AppBundle\Validator\Constraints
 *
 * @Annotation
 */
class UniqueId extends Constraint
{
    /**
     * @var string
     */
    public $message = 'Has items with non-unique `%id%` identifier.';

    /**
     * @var string
     */
    public $property;

    public function getDefaultOption()
    {
        return 'property';
    }

    public function getTargets()
    {
        return Constraint::PROPERTY_CONSTRAINT;
    }
}