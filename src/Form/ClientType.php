<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TextType::class,[
                'required'=> false,
                'attr'=>[
                    'class'=>'input-shadow w-full sm:flex-grow p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500'
                ]
            ])
            ->add('adresse', TextType::class,[
                'required'=> false,
                'attr'=>[
                    'class'=>'input-shadow w-full sm:flex-grow p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500'
                ]
            ])
            ->add('surnom', TextType::class,[
                'required'=> false,
                'attr'=>[
                    'class'=>'input-shadow w-full sm:flex-grow p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500'
                ]
            ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
