<?php

namespace UABundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublishProjectDocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template', EntityType::class, ['class' => 'UABundle\Entity\ProjectDocumentTemplate', 'required' => true])
            ->add('project', EntityType::class, ['class' => 'UABundle\Entity\Project', 'required' => true])
            ->add('manager', EntityType::class, ['class' => 'UABundle\Entity\ProjectManager', 'required' => true])
            ->add('contact', EntityType::class, ['class' => 'UABundle\Entity\ProjectContact', 'required' => true])
            ->add('consultant', EntityType::class, ['class' => 'UABundle\Entity\Consultant', 'required' => true]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
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
