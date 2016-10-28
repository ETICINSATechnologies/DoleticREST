<?php

namespace UABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project', 'entity', ['class' => 'UABundle\Entity\Project', 'choice_label' => 'name'])
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('jehAmount', 'integer')
            ->add('jehCost', 'integer')
            ->add('startDate', 'date', ['widget' => 'single_text', 'format' => 'dd/MM/yyyy'])
            ->add('endDate', 'date', ['widget' => 'single_text', 'format' => 'dd/MM/yyyy'])
            ->add('ended', 'checkbox', ['read_only' => true, 'value' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\Task'
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
