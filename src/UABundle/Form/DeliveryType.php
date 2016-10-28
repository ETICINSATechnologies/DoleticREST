<?php

namespace UABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('task', 'entity', ['class' => 'UABundle\Entity\Task', 'choice_label' => 'name'])
            ->add('number', 'integer')
            ->add('name', 'text')
            ->add('content', 'textarea')
            ->add('delivered', 'checkbox')
            ->add('deliveryDate', 'date')
            ->add('billed', 'checkbox')
            ->add('paid', 'checkbox')
            ->add('paymentDate', 'date');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UABundle\Entity\Delivery'
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
