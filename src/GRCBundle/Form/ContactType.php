<?php

namespace GRCBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class, ['class' => 'GRCBundle\Entity\ContactType', 'choice_label' => 'label'])
            ->add('gender', EntityType::class, ['class' => 'KernelBundle\Entity\Gender', 'choice_label' => 'label'])
            ->add('firm', EntityType::class, ['class' => 'GRCBundle\Entity\Firm', 'choice_label' => 'name'])
            ->add('prospector', EntityType::class, ['class' => 'KernelBundle\Entity\User', 'choice_label' => 'fullName'])
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('phone', IntegerType::class, ['required' => false])
            ->add('cellPhone', IntegerType::class, ['required' => false])
            ->add('email', EmailType::class, ['required' => false])
            ->add('origin', TextType::class, ['required' => false])
            ->add('error', CheckboxType::class)
            ->add('satisfied', CheckboxType::class)
            ->add('fromProspecting', CheckboxType::class)
            ->add('role', TextType::class, ['required' => false])
            ->add('notes', TextareaType::class, ['required' => false])
            ->add('nextProspecting', DateType::class, ['widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'required' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'GRCBundle\Entity\Contact'
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
