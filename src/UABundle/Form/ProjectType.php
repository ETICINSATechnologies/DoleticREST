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
            ->add('firm', 'entity', ['class' => 'GRCBundle\Entity\Firm', 'choice_label' => 'name'])
            ->add('auditor', 'entity', ['class' => 'RHBundle\Entity\UserData', 'choice_label' => 'fullname'])
            ->add('field', 'entity', ['class' => 'UABundle\Entity\ProjectField', 'choice_label' => 'label'])
            ->add('origin', 'entity', ['class' => 'UABundle\Entity\ProjectOrigin', 'choice_label' => 'label'])
            ->add('status', 'entity', ['class' => 'UABundle\Entity\ProjectStatus', 'choice_label' => 'label'])
            ->add('name', 'text')
            ->add('description', 'textarea', ['required' => false])
            ->add('signDate', 'date', ['required' => false])
            ->add('endDate', 'date', ['required' => false])
            ->add('managementFee', 'integer')
            ->add('applicationFee', 'integer')
            ->add('rebilledFee', 'integer')
            ->add('advance', 'integer')
            ->add('secret', 'checkbox')
            ->add('critical', 'checkbox')
            ->add('disabled', 'checkbox', ['read_only' => true, 'value' => false])
            ->add('archived', 'checkbox', ['read_only' => true, 'value' => false]);
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
