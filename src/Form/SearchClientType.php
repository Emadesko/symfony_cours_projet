<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('telephone', TextType::class, [
            'required' => false,
            'attr' => [
                'placeholder' => 'Filtrer par Telephone',
                'class' => 'p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none w-auto',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez renseigner un numéro de téléphone.',
                ]),
                
                // new Regex(
                //     '/^(77|78|76)([0-9]{7})$/',
                //     'Le numéro de téléphone doit être au format 76XXXXXX ou 77XXXXXX ou 78XXXXXX'
                // )

            ]

        ])
        ->add('ok', SubmitType::class, [
                'attr' => [
                    'class' => 'px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700'
                ]
        ]);
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
