<?php

namespace App\Form;

use App\Dto\CommentDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class, [
                'label' => 'Your name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter your name',
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Comment',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5,
                    'placeholder' => 'Enter your comment',
                ],
            ])
        ;
    }

    public function configureoptions(optionsresolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommentDTO::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
