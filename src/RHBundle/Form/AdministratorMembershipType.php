<?php

namespace RHBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdministratorMembershipType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, ['class' => 'KernelBundle\Entity\User', 'choice_label' => 'fullName'])
            ->add('startDate', DateType::class, ['widget' => 'single_text', 'format' => 'dd/MM/yyyy'])
            ->add('endDate', DateType::class, ['required' => false, 'widget' => 'single_text', 'format' => 'dd/MM/yyyy'])
            ->add('feePaid', CheckboxType::class)
            ->add('formFilled', CheckboxType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'RHBundle\Entity\AdministratorMembership',
            'allow_extra_fields' => true
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
