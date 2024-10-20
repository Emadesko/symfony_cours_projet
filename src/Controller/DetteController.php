<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DetteController extends AbstractController
{
    #[Route('/dette', name: 'dette.index')]
    public function index(): Response
    {
        return $this->render('dette/index.html.twig', [
            'controller_name' => 'DetteController',
        ]);
    }
    #[Route('/dette/clientDettes', name: 'dette.clientDettes')]
    public function clientDettes(): Response
    {
        return $this->render('dette/clientDettes.html.twig', [
            'controller_name' => 'DetteController',
        ]);
    }
    #[Route('/dette/store', name: 'dette.store')]
    public function store(): Response
    {
        return $this->render('dette/form.html.twig', [
            'controller_name' => 'DetteController',
        ]);
    }
}
