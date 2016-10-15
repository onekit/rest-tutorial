<?php
namespace AppBundle\Validator\Constraints;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class EntityExistsValidator
 * @package AppBundle\Validator\Constraints
 */
class EntityExistsValidator extends ConstraintValidator
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($constraint instanceof EntityExists) {
            if ($constraint->nullable) {
                return;
            }
            if (!$value) {
                $this->generateViolation($constraint);
                return;
            }
            $repository = $this->em->getRepository($constraint->class);
            $entity = $repository->find($value);
            if (!$entity) {
                $this->generateViolation($constraint);
            }
        } else {
            throw new \Exception();
        }
    }

    protected function generateViolation(EntityExists $constraint)
    {
        $reflection = new \ReflectionClass($constraint->class);
        $this->context
            ->buildViolation($constraint->message)
            ->setParameter('%entity%', $reflection->getShortName())
            ->addViolation();
    }

}