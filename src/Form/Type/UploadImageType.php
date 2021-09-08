<?php

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;

class UploadImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'expanded' => true,
                'multiple' => true,
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'minMessage' => "Please select at least one category",
                    ]),
                ],
                'label' => 'Please select at least one category',
                'choice_label' => function(Category $category)
                {
                    return $category->getName();
                }
            ])
            ->add('image', FileType::class, [
                'label' => 'Please upload an image',
                'mapped' => false,
            ])
             ->add('upload', SubmitType::class, [
                 'attr' => ['class' => 'btn btn-success btn-lg'],
             ])
           ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }


}