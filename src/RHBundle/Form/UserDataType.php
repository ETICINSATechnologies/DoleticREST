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
            ->add('gender', 'entity', ['choice_label' => 'label'])
            ->add('firstname', 'text')
            ->add('lastname', 'text')
            ->add('birthdate', 'date', ['required' => false])
            ->add('department', 'entity', ['choice_label' => 'label'])
            ->add('schoolYear', 'entity', ['choice_label' => 'label'])
            ->add('recruitmentEvent', 'entity', ['choice_label' => 'label', 'required' => false])
            ->add('tel', 'integer', ['required' => false])
            ->add('address', 'text', ['required' => false])
            ->add('city', 'text', ['required' => false])
            ->add('postalCode', 'integer', ['required' => false])
            ->add('country', 'entity', ['choice_label' => 'label']);
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
