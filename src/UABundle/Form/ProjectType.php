<?php

namespace UABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firm', 'entity', ['choice_label' => 'name'])
            ->add('auditor', 'entity', ['choice_label' => 'fullname'])
            ->add('field', 'entity', ['choice_label' => 'label'])
            ->add('origin', 'entity', ['choice_label' => 'label'])
            ->add('status', 'entity', ['choice_label' => 'label'])
            ->add('number', 'integer')
            ->add('name', 'text')
            ->add('description', 'textarea', ['required' => false])
            ->add('signDate', 'date', ['required' => false])
            ->add('endDate', 'date', ['required' => false])
            ->add('managementFee', 'integer')
            ->add('appFee', 'integer')
            ->add('rebilledFee', 'integer')
            ->add('advance', 'integer')
            ->add('secret', 'checkbox')
            ->add('critical', 'checkbox')
            ->add('disabled', 'checkbox')
            ->add('disabledSince', 'date', ['required' => false])
            ->add('disabledUntil', 'date', ['required' => false])
            ->add('archived', 'checkbox')
            ->add('archivedSince', 'date', ['required' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\Project'
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
