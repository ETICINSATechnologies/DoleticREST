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

    const ADD_MODE = 0;
    const EDIT_MODE = 1;
    const SIGN_MODE = 2;
    const END_MODE = 3;
    const AUDITOR_MODE = 4;
    const DISABLE_MODE = 5;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mode = isset($options['mode']) ? $options['mode'] : self::ADD_MODE;

        $builder
            ->add('firm', EntityType::class, ['class' => 'GRCBundle\Entity\Firm', 'choice_label' => 'name', 'disabled' => $mode > self::EDIT_MODE])
            ->add('auditor', EntityType::class, ['class' => 'KernelBundle\Entity\User', 'choice_label' => 'fullName', 'disabled' => $mode !== self::AUDITOR_MODE])
            ->add('field', EntityType::class, ['class' => 'UABundle\Entity\ProjectField', 'choice_label' => 'label', 'disabled' => $mode > self::EDIT_MODE])
            ->add('origin', EntityType::class, ['class' => 'UABundle\Entity\ProjectOrigin', 'choice_label' => 'label', 'disabled' => $mode > self::EDIT_MODE])
            ->add('status', EntityType::class, ['class' => 'UABundle\Entity\ProjectStatus', 'choice_label' => 'label', 'disabled' => $mode > self::EDIT_MODE])
            ->add('name', TextType::class, ['disabled' => $mode > self::EDIT_MODE])
            ->add('description', TextareaType::class, ['disabled' => $mode > self::EDIT_MODE])
            ->add('signDate', DateType::class, ['disabled' => $mode !== self::SIGN_MODE, 'format' => 'dd/MM/yyyy', 'widget' => 'single_text'])
            ->add('endDate', DateType::class, ['disabled' => $mode !== self::END_MODE, 'format' => 'dd/MM/yyyy', 'widget' => 'single_text'])
            ->add('managementFee', IntegerType::class, ['disabled' => $mode !== self::EDIT_MODE])
            ->add('applicationFee', IntegerType::class, ['disabled' => $mode !== self::EDIT_MODE])
            ->add('rebilledFee', IntegerType::class, ['disabled' => $mode !== self::EDIT_MODE])
            ->add('advance', IntegerType::class, ['disabled' => $mode !== self::EDIT_MODE])
            ->add('expectedDuration', IntegerType::class, ['disabled' => $mode > self::EDIT_MODE, 'required' => false])
            ->add('secret', CheckboxType::class, ['disabled' => $mode !== self::ADD_MODE])
            ->add('critical', CheckboxType::class, ['disabled' => $mode !== self::ADD_MODE])
            ->add('disabledUntil', DateType::class, ['disabled' => $mode !== self::DISABLE_MODE, 'format' => 'dd/MM/yyyy', 'widget' => 'single_text'])
            ->add('currentAsManager', CheckboxType::class, ['mapped' => false, 'disabled' => $mode !== self::ADD_MODE, 'value' => $mode !== self::ADD_MODE]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\Project',
            'mode' => self::ADD_MODE,
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
