<?php

namespace App\Form\Type;

use App\DTO\PasswordGenerator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordGeneratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('length', IntegerType::class, [
                'attr' => [
                    'min' => 12,
                    'max' => 92,
                    'placeholder' => 'Password length (minimum 12 characters)',
                ],
                'label' => false,

//                'label' => 'hey',
            ])
            ->add('upperCase', CheckboxType::class, [
                'required' => false,
                'label' => 'Include Uppercase Letters'
            ])
            ->add('lowerCase', CheckboxType::class, [
                'required' => false,
                'label' => 'Include Lowercase Letters'
            ])
            ->add('numbers', CheckboxType::class, [
                'required' => false,
                'label' => 'Include Numbers'
            ])
            ->add('symbols', CheckboxType::class, [
                'required' => false,
                'label' => 'Include Special Symbols'
            ])
            ->add('generate', SubmitType::class, [
                'label' => 'CREATE PASSWORD',
                'attr' => ['class' => 'btn-light fs-5'],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PasswordGenerator::class
            ],
        );
    }
}