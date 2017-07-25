<?php

namespace UABundle\Form;

use Doctrine\DBAL\Types\BooleanType;
use KernelBundle\Form\DocumentTemplateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandardDocumentTemplateType extends DocumentTemplateType
{

    const ADD_MODE = 0;
    const EDIT_MODE = 1;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $mode = isset($options['mode']) ? $options['mode'] : self::ADD_MODE;

        $builder
            ->add('version', TextType::class)
            ->add('description', TextType::class, ['required' => false])
            ->add('visibility', TextType::class)
            ->add('label', TextType::class)
            ->add('deprecated', CheckboxType::class)
            ->add('file', FileType::class, [
                'data_class' => null,
                'disabled' => $mode == self::EDIT_MODE,
                'required' => $mode == self::ADD_MODE
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'mode' => self::ADD_MODE,
            'data_class' => 'UABundle\Entity\StandardDocumentTemplate',
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
