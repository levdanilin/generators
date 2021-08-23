<?php

namespace App\Form\Type;

use App\Entity\BasicAuth;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BasicAuthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('directoryPath', TextType::class, [
                'required' => false,
            ])
            ->add('htpasswdPath', TextType::class)
            ->add('userName', TextType::class)
            ->add('password', TextType::class)
            ->add('generate', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BasicAuth::class,
        ]);
    }

}