<?php

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $constraints = new NotNull();
        $builder
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'expanded' => true,
                'multiple' => true,
                'label' => 'Please select al least one category',
                'choice_label' => function(Category $category)
                {
                    return $category->getName();
                }
            ])
            ->add('image', FileType::class, [
                'label' => 'Please upload an image',
                'mapped' => false,
                'constraints' => [
                    new NotNull()
                ]

            ])
             ->add('upload', SubmitType::class)
             ->add('get', SubmitType::class)
           ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }


}