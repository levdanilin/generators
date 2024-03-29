<?php

namespace App\Form\Type;

use App\DTO\MailTo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailToType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', EmailType::class)
            ->add('cc', EmailType::class, [
                'required' => false,
            ])
            ->add('bcc', EmailType::class, [
            'required' => false,
            ])
            ->add('subject', TextType::class, [
                'required' => false,
            ])
            ->add('body', TextareaType::class, [
            'attr' => [
                'cols'=> 35, 'rows' => 7],
                'required' => false])
            ->add('generate', SubmitType::class, [
                'label' => 'GENERATE LINK',
                'attr' => ['class' => 'btn-light fs-5'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MailTo::class,
        ]);
    }


}