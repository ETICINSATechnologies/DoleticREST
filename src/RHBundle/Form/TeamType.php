<?php

namespace RHBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('leader', 'entity', ['choice_label' => 'fullname'])
            ->add('division', 'entity', ['choice_label' => 'label'])
            ->add('name', 'text')
            ->add('members', 'entity', ['choice_label' => 'fullname', 'multiple' => true]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'RHBundle\Entity\Team'
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
