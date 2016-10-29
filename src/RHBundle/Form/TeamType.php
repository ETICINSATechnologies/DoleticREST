<?php

namespace RHBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('leader', EntityType::class, ['class' => 'RHBundle\Entity\UserData', 'choice_label' => 'fullname'])
            ->add('division', EntityType::class, ['class' => 'KernelBundle\Entity\Division', 'choice_label' => 'label'])
            ->add('name', TextType::class)
            ->add('members', EntityType::class, [
                'class' => 'RHBundle\Entity\UserData',
                'choice_label' => 'fullname',
                'multiple' => true,
                'required' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'RHBundle\Entity\Team'
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
