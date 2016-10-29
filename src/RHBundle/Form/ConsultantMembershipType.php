<?php

namespace RHBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultantMembershipType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userData', EntityType::class, ['choice_label' => 'fullname'])
            ->add('startDate', DateType::class)
            ->add('socialNumber', TextType::class, ['required' => false])
            ->add('feePaid', CheckboxType::class)
            ->add('formFilled', CheckboxType::class)
            ->add('ribGiven', CheckboxType::class)
            ->add('idGiven', CheckboxType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'RHBundle\Entity\ConsultantMembership'
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
