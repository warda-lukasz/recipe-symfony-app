<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                'constraints' => [
                    new NotBlank(['message' => 'Author name is required']),
                    new Length([
                        'max' => 255,
                        'min' => 2,
                        'maxMessage' => 'Author name cannot exceed {{ limit }} characters',
                        'minMessage' => 'Author name must be at least {{ limit }} characters long',
                    ]),
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Comment',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5,
                    'placeholder' => 'Enter your comment',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Comment content is required']),
                    new Length([
                        'min' => 10,
                        'max' => 1000,
                        'minMessage' => 'Comment must be at least {{ limit }} characters long',
                        'maxMessage' => 'Comment cannot exceed {{ limit }} characters',
                    ]),
                ],
            ])
        ;
    }

    public function configureoptions(optionsresolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
