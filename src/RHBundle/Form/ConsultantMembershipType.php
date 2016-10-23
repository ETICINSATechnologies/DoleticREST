<?php

namespace RHBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultantMembershipType extends AbstractType
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
            ->add('socialNumber', 'text', ['required' => false])
            ->add('feePaid', 'checkbox')
            ->add('formFilled', 'checkbox')
            ->add('ribGiven', 'checkbox')
            ->add('idGiven', 'checkbox');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'RHBundle\Entity\ConsultantMembership'
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
