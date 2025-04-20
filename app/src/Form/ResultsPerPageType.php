<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ResultsPerPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('limit', ChoiceType::class, [
                'choices' => [
                    '6' => 6,
                    '12' => 12,
                    '24' => 24,
                    '48' => 48,
                ],
                'label' => 'Results per page',
                'multiple' => false,
                'attr' => [
                    'name' => 'limit',
                ],
            ]);
    }
}
