<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Form\SearchClientType;
use App\Repository\DetteRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetteController extends AbstractController
{
    #[Route('/dette', name: 'dette.index')]
    public function index(EntityManagerInterface $entityManager,Request $request,ClientRepository $clientRepository): Response
    {
        $client=new Client();
        $clientForm=$this->createForm(ClientType::class,$client);
        $clientForm->handleRequest($request);
        $searchForm=$this->createForm(SearchClientType::class);
        $searchForm->handleRequest($request);
        $clientSearched=null;
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $clientSearched = $clientRepository->findOneBy(['telephone'=>$searchForm->getData()['telephone']]);
        }
        if ($clientForm->isSubmitted() && $clientForm->isValid()) {
            # code...
            // if ($request->query->get("login")!="") {
                //     $user=new User();
                //     $user->setLogin($request->query->get("login"));
                //     $user->setNom($request->query->get("nom"));
                //     $user->setPrenom($request->query->get("prenom"));
                //     $user->setPassword($request->query->get("password"));
                //     $user->setUpdateAt(new \DateTimeImmutable());;
                //     $user->setCreateAt(new \DateTimeImmutable());;
                //     $client->setUser($user);
                //     $entityManager->persist($user);
                // }
            $entityManager->persist($client);
            $entityManager->flush(); 
            return $this->redirectToRoute('client.index');
        }
        return $this->render('dette/index.html.twig', [
            'controller_name' => 'DetteController',
            'formClient'=>$clientForm->createView(),
            'searchForm'=>$searchForm->createView(),
            'client'=> $clientSearched,
        ]);
    }

   
    #[Route('/dette/store', name: 'dette.store')]
    public function store(ClientRepository $clientRepository,DetteRepository $detteRepository,Request $request): Response
    {
        $client=$clientRepository->find($request->get("id"));
        $montant=$detteRepository->getTotalMontant($client->getId());
        $montantVerser=$detteRepository->getTotalMontantVerser($client->getId());
        return $this->render('dette/form.html.twig', [
            'controller_name' => 'DetteController',
            'client'=>$client,
            'total'=>$montant,
            'verser'=>$montantVerser,
            'du'=>$montant-$montantVerser,
        ]);
    }
}
