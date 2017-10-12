<?php

namespace KernelBundle\Validator\Constraints;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CorrectPasswordValidator extends ConstraintValidator
{
    /**
     * @var EncoderFactory
     */
    private $encoderFactory;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(EncoderFactory $encoderFactory, TokenStorage $tokenStorage)
    {
        $this->encoderFactory = $encoderFactory;
        $this->tokenStorage = $tokenStorage;
    }

    public function validate($value, Constraint $constraint)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $encoder = $this->encoderFactory->getEncoder($user);
        $salt = $user->getSalt();

        if(!$encoder->isPasswordValid($user->getPassword(), $value, $salt)) {
            $this->context->addViolation($constraint->message);
        }
    }
}