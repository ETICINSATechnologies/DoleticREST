<?php

namespace UABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AmendmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project', 'entity', ['choice_label' => 'name'])
            ->add('types', 'entity', ['choice_label' => 'label', 'multiple' => true])
            ->add('content', 'textarea')
            ->add('attributable', 'checkbox')
            ->add('date', 'date');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\Amendment'
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
