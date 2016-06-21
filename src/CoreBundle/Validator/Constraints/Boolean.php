<?php

namespace CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Boolean
 * @package CoreBundle\Validator\Constraints
 * @Annotation
 */
class Boolean extends Constraint
{
    public $message = '"%string%" doesn\'t a boolean value';
}