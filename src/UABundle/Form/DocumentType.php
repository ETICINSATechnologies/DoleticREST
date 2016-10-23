<?php

namespace UABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project', 'entity', ['choice_label' => 'name'])
            ->add('template', 'entity', ['choice_label' => 'label'])
            ->add('auditor', 'entity', ['choice_label' => 'fullname'])
            ->add('valid', 'checkbox');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\Document'
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
