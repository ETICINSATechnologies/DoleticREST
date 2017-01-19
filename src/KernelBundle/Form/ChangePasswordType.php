<?php

namespace KernelBundle\Form;

use KernelBundle\Validator\Constraints\CorrectPassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old', PasswordType::class, ['constraints' => [new CorrectPassword()]])
            ->add('new', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_name' => 'first',
                'second_name' => 'second',
                'invalid_message' => 'Les deux mots de passes sont différents ou trop courts (minimum 10 caractères).',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10])
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "";
    }
}
