<?php

namespace UABundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AmendmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('project', EntityType::class, ['class' => 'UABundle\Entity\Project', 'choice_label' => 'name'])
            ->add('types', EntityType::class, ['class' => 'UABundle\Entity\AmendmentType', 'choice_label' => 'label', 'multiple' => true])
            ->add('content', TextareaType::class)
            ->add('attributable', CheckboxType::class)
            ->add('date', DateType::class, ['widget' => 'single_text', 'format' => 'dd/MM/yyyy']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\Amendment',
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
