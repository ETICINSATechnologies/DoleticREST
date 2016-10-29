<?php

namespace RHBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDataType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', EntityType::class, ['class' => 'KernelBundle\Entity\Gender', 'choice_label' => 'label'])
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('birthdate', DateType::class, ['required' => false])
            ->add('department', EntityType::class, ['class' => 'RHBundle\Entity\Department', 'choice_label' => 'label'])
            ->add('schoolYear', EntityType::class, ['class' => 'RHBundle\Entity\SchoolYear', 'choice_label' => 'label'])
            ->add('recruitmentEvent', EntityType::class, ['class' => 'RHBundle\Entity\RecruitmentEvent', 'choice_label' => 'label', 'required' => false])
            ->add('tel', IntegerType::class, ['required' => false])
            ->add('address', TextType::class, ['required' => false])
            ->add('city', TextType::class, ['required' => false])
            ->add('postalCode', IntegerType::class, ['required' => false])
            ->add('old', CheckboxType::class, ['read_only' => true, 'value' => false])
            ->add('country', EntityType::class, ['class' => 'KernelBundle\Entity\Country', 'choice_label' => 'label']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'RHBundle\Entity\UserData'
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
