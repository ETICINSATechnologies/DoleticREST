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

class DeliveryType extends AbstractType
{

    const ADD_MODE = 0;
    const EDIT_MODE = 1;
    const DELIVER_MODE = 2;
    const PAY_MODE = 3;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mode = isset($options['mode']) ? $options['mode'] : self::ADD_MODE;

        $builder
            ->add('task', EntityType::class, ['class' => 'UABundle\Entity\Task', 'choice_label' => 'name', 'disabled' => $mode > self::EDIT_MODE])
            ->add('number', IntegerType::class, ['disabled' => $mode > self::EDIT_MODE])
            ->add('content', TextareaType::class, ['disabled' => $mode > self::EDIT_MODE])
            ->add('deliveryDate', DateType::class, ['disabled' => $mode !== self::DELIVER_MODE, 'format' => 'dd/MM/yyyy', 'widget' => 'single_text'])
            ->add('billed', CheckboxType::class, ['disabled' => $mode > self::EDIT_MODE])
            ->add('paymentDate', DateType::class, ['disabled' => $mode !== self::PAY_MODE, 'format' => 'dd/MM/yyyy', 'widget' => 'single_text']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\Delivery',
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
