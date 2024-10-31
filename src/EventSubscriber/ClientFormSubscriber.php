<?php

namespace App\EventSubscriber;

use App\Form\UserType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ClientFormSubscriber implements EventSubscriberInterface
{
    public function onOnFormPreSubmit($event): void
    {
        $formData = $event->getData(); // Récupère les données du formulaire
        $form = $event->getForm();
        if (isset($formData['addUser']) && $formData['addUser'] == "1") {
            $form
                ->add('user', UserType::class, [
                    'label' => false,
                    'attr' => [],
                ]);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'onFormPreSubmit' => 'onOnFormPreSubmit',
        ];
    }
}
