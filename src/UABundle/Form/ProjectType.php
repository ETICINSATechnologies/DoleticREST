<?php

namespace UABundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('firm', EntityType::class, ['class' => 'GRCBundle\Entity\Firm', 'choice_label' => 'name'])
            ->add('auditor', EntityType::class, ['class' => 'RHBundle\Entity\UserData', 'choice_label' => 'fullname'])
            ->add('field', EntityType::class, ['class' => 'UABundle\Entity\ProjectField', 'choice_label' => 'label'])
            ->add('origin', EntityType::class, ['class' => 'UABundle\Entity\ProjectOrigin', 'choice_label' => 'label'])
            ->add('status', EntityType::class, ['class' => 'UABundle\Entity\ProjectStatus', 'choice_label' => 'label'])
            ->add('name', TextType::class)
            ->add('description', TextareaType::class, ['required' => false])
            ->add('signDate', DateType::class, ['required' => false])
            ->add('endDate', DateType::class, ['required' => false])
            ->add('managementFee', IntegerType::class)
            ->add('applicationFee', IntegerType::class)
            ->add('rebilledFee', IntegerType::class)
            ->add('advance', IntegerType::class)
            ->add('secret', CheckboxType::class)
            ->add('critical', CheckboxType::class)
            ->add('disabled', CheckboxType::class, ['read_only' => true, 'value' => false])
            ->add('archived', CheckboxType::class, ['read_only' => true, 'value' => false]);
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
