<?php
namespace CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class PasswordValidator
 * @package CoreBundle\Validator\Constraints
 */
class PasswordValidator extends ConstraintValidator
{
	/**
	 * @param mixed $value
	 * @param Constraint $constraint
	 */
    public function validate($value, Constraint $constraint)
    {
        $regexp = '$.{8,}$';
        if (!preg_match($regexp, $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}