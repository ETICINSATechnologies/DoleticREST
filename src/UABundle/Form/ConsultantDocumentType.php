<?php

namespace UABundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultantDocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auditor', EntityType::class, ['class' => 'KernelBundle\Entity\User', 'choice_label' => 'fullName', 'disabled' => true])
            ->add('file', FileType::class)
            ->add('valid', CheckboxType::class)
            ->add('template', EntityType::class, ['class' => 'UABundle\Entity\ConsultantDocumentTemplate', 'choice_label' => 'label'])
            ->add('consultant', EntityType::class, ['class' => 'UABundle\Entity\Consultant']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\ConsultantDocument',
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
