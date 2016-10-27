<?php

namespace RHBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDataType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', 'entity', ['class' => 'KernelBundle\Entity\Gender', 'choice_label' => 'label'])
            ->add('firstname', 'text')
            ->add('lastname', 'text')
            ->add('email', 'email')
            ->add('birthdate', 'date', ['required' => false])
            ->add('department', 'entity', ['class' => 'RHBundle\Entity\Department', 'choice_label' => 'label'])
            ->add('schoolYear', 'entity', ['class' => 'RHBundle\Entity\SchoolYear', 'choice_label' => 'label'])
            ->add('recruitmentEvent', 'entity', ['class' => 'RHBundle\Entity\RecruitmentEvent', 'choice_label' => 'label', 'required' => false])
            ->add('tel', 'integer', ['required' => false])
            ->add('address', 'text', ['required' => false])
            ->add('city', 'text', ['required' => false])
            ->add('postalCode', 'integer', ['required' => false])
            ->add('old', 'checkbox', ['read_only' => true, 'value' => false])
            ->add('country', 'entity', ['class' => 'KernelBundle\Entity\Country', 'choice_label' => 'label']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'RHBundle\Entity\UserData'
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
