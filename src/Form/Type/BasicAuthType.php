<?php

namespace App\Form\Type;

use App\Entity\BasicAuth;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('userData', CollectionType::class, [
                'by_reference' => false,
                'entry_type' => UserDataType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('generate', SubmitType::class,
                [
                'row_attr' => [
                ],
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BasicAuth::class,
        ]);
    }

}