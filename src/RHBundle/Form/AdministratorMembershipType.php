<?php

namespace RHBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdministratorMembershipType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userData', 'entity', ['choice_label' => 'fullname'])
            ->add('startDate', 'date')
            ->add('endDate', 'date', ['required' => false])
            ->add('feePaid', 'checkbox')
            ->add('formFilled', 'checkbox');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'RHBundle\Entity\AdministratorMembership'
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
