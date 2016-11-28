<?php

namespace UABundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template', EntityType::class, ['class' => 'KernelBundle\Entity\DocumentTemplate', 'choice_label' => 'label'])
            ->add('auditor', EntityType::class, ['class' => 'KernelBundle\Entity\User', 'choice_label' => 'fullName'])
            ->add('file', FileType::class)
            ->add('valid', CheckboxType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\Document'
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
