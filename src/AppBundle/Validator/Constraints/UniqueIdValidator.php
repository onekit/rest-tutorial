<?php
namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueIdValidator extends ConstraintValidator
{
    /**
     * @param array $items
     * @param Constraint $constraint
     */
    public function validate($items, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueId) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\UniqueId');
        }
        if (!isset($constraint->property)) {
            throw new InvalidArgumentException('Missing property value.');
        }

        $checkList = [];
        foreach ($items as $item) {
            if (!property_exists($item, $constraint->property)) {
                throw new InvalidArgumentException(sprintf('Unsupported class "%s": missing "%s" property.', get_class($item), $constraint->property));
            }
            if (isset($checkList[$item->{$constraint->property}])) {
                $this->context
                    ->buildViolation($constraint->message)
                    ->setParameter('%id%', $constraint->property)
                    ->addViolation();
            }
            $checkList[$item->{$constraint->property}] = 1;
        }
    }
}