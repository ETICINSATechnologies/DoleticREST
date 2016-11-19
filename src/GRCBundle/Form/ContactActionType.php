<?php

namespace GRCBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactActionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class, ['class' => 'GRCBundle\Entity\ContactActionType', 'choice_label' => 'label'])
            ->add('contact', EntityType::class, ['class' => 'GRCBundle\Entity\Contact', 'choice_label' => 'fullname'])
            ->add('prospector', EntityType::class, ['class' => 'RHBundle\Entity\UserData', 'choice_label' => 'fullname'])
            ->add('replied', CheckboxType::class)
            ->add('date', DateType::class, ['widget' => 'single_text', 'format' => 'dd/MM/yyyy'])
            ->add('notes', TextareaType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'GRCBundle\Entity\ContactAction'
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
