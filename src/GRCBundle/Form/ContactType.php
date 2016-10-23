<?php

namespace GRCBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'entity', ['choice_label' => 'label'])
            ->add('gender', 'entity', ['choice_label' => 'label'])
            ->add('firm', 'entity', ['choice_label' => 'name'])
            ->add('firstname', 'text')
            ->add('lastname', 'text')
            ->add('phone', 'integer', ['required' => false])
            ->add('cellPhone', 'integer', ['required' => false])
            ->add('email', 'email', ['required' => false])
            ->add('role', 'text', ['required' => false])
            ->add('notes', 'textarea', ['required' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'GRCBundle\Entity\Contact'
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
