<?php

namespace KernelBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CorrectPassword extends Constraint
{
    public $message = "L'ancien mot de passe soumis est incorrect.";
}