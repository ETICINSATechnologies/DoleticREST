<?php

namespace GRCBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FirmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'entity', ['class' => 'GRCBundle\Entity\FirmType', 'choice_label' => 'label'])
            ->add('country', 'entity', ['class' => 'KernelBundle\Entity\Country', 'choice_label' => 'label'])
            ->add('siret', 'text', ['required' => false])
            ->add('name', 'text')
            ->add('address', 'text', ['required' => false])
            ->add('city', 'text', ['required' => false])
            ->add('postalCode', 'integer', ['required' => false]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'GRCBundle\Entity\Firm'
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
