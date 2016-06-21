<?php

namespace CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Number
 * @package CoreBundle\Validator\Constraints
 * @Annotation
 */
class Number extends Constraint
{
    public $message = '"%string%" doesn\'t a number';
}