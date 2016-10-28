<?php

namespace UABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultantType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project', 'entity', ['class' => 'UABundle\Entity\Project', 'choice_label' => 'name'])
            ->add('userData', 'entity', ['class' => 'RHBundle\Entity\UserData', 'choice_label' => 'fullname'])
            ->add('jehAssigned', 'integer')
            ->add('payByJeh', 'integer');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\Consultant'
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
