<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DetteController extends AbstractController
{
    #[Route('/dette', name: 'dette.index')]
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        $client=new Client();
        $form=$this->createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
            'formClient'=>$form->createView()
        ]);
    }

    #[Route('/dette/clientDettes', name: 'dette.clientDettes')]
    public function clientDettes(Request $request,ClientRepository $clientRepository,DetteRepository $detteRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $type = $request->query->getString('type', "all");
        $limit = 5;
        $client=$clientRepository->find($request->get("id"));
        $montant=$detteRepository->getTotalMontant($client->getId());
        $montantVerser=$detteRepository->getTotalMontantVerser($client->getId());
        $dettes=$detteRepository->paginateDettes($page,$limit,$client->getId(),$type);

        $count = $dettes->count();
        $maxPage = ceil($count / $limit);
        return $this->render('dette/clientDettes.html.twig', [
            'controller_name' => 'DetteController',
            'client' => $client,
            'dettes' => $dettes,
            'total'=>$montant,
            'verser'=>$montantVerser,
            'du'=>$montant-$montantVerser,
            'page' => $page,
            'maxPage' => $maxPage,
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
