<?php

namespace App\Controller;

use App\Entity\User;
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

class ClientController extends AbstractController
{
    #[Route('/client', name: 'client.index',methods:['GET','POST'])]
    public function index(Request $request,ClientRepository $clientRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $form=$this->createForm(SearchClientType::class);
        $form->handleRequest($request);
        $clients=[];
        $telephone=$request->get('telephone',"");
        if ($request->query->has('search_client')) {
            $page=1;
            $telephone=$request->query->all('search_client')['telephone'];
        }
        $clients = $clientRepository->paginateClients($page,$limit,$telephone);
        $count = $clients->count();
        $maxPage = ceil($count / $limit);
        return $this->render('client/index.html.twig', [
            'datas' => $clients,
            'telephone' => $telephone,
            'searchForm' => $form->createView(),
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }

    #[Route('/client/dettes/{idClient}', name: 'client.dettes')]
    public function clientDettes(Request $request,ClientRepository $clientRepository,DetteRepository $detteRepository,int $idClient): Response
    {
        $page = $request->query->getInt('page', 1);
        $statut = $request->query->getString('statut', "all");
        $limit = 2;
        $client=$clientRepository->find($idClient);
        $montant=$detteRepository->getTotalMontant($client->getId());
        $montantVerser=$detteRepository->getTotalMontantVerser($client->getId());
        $dettes=$detteRepository->paginateDettes($page,$limit,$client->getId(),$statut);
        $count = $dettes->count();
        $maxPage = ceil($count / $limit);
        return $this->render('client/dette.html.twig', [
            'controller_name' => 'DetteController',
            'client' => $client,
            'dettes' => $dettes,
            'total'=>$montant,
            'verser'=>$montantVerser,
            'du'=>$montant-$montantVerser,
            'statut'=>$statut,
            'page' => $page,
            'maxPage' => $maxPage,
        ]);
    }

    #[Route('/client/store', name: 'client.store',methods:['GET','POST'])]
    public function store(Request $request,EntityManagerInterface $entityManager): Response
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
        return $this->render('client/form.html.twig', [
            'formClient'=>$form->createView()
        ]);
    }
}
