<?php
namespace AppBundle\Validator\Constraints;


use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class UniqueUserValidator extends UniqueEntityValidator
{

    /**
     * @param \object $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $user = new User();
        if (property_exists($value, 'email')) {
            $user->setEmail($value->email);
        }
        if (property_exists($value, 'username')) {
            $user->setUsername($value->username);
        }
        parent::validate($user, $constraint);
    }
}