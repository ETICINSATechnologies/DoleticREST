<?php

namespace KernelBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPositionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', EntityType::class, [
                'class' => 'KernelBundle\Entity\Position',
                'choice_label' => 'label'
            ])
            ->add('user', EntityType::class, [
                'class' => 'KernelBundle\Entity\User',
                'choice_label' => 'username'
            ])
            ->add('main', CheckboxType::class);
    }

    private function refactorRoles($originRoles)
    {
        $roles = array();
        $rolesAdded = array();

        foreach ($originRoles as $roleParent => $rolesChild) {
            $tmpRoles = array_values($rolesChild);
            $rolesAdded = array_merge($rolesAdded, $tmpRoles);
            $roles[$roleParent] = array_combine($tmpRoles, $tmpRoles);
        }
        $rolesParent = array_keys($originRoles);
        foreach ($rolesParent as $roleParent) {
            if (!in_array($roleParent, $rolesAdded)) {
                $roles['-----'][$roleParent] = $roleParent;
            }
        }

        return $roles;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'KernelBundle\Entity\UserPosition'
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
