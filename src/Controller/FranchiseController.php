<?php

namespace App\Controller;


use App\Form\FranchiseSearchType;
use App\Repository\FranchiseRepository;
use App\Repository\StructureRepository;
use App\Search\FranchiseSearch;
use App\Search\StructureSearch;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/franchise')]
class FranchiseController extends AbstractController
{
    public function __construct(private readonly PaginatorInterface $paginator)
    {
    }


    #[Route('/list', name: 'app_list_franchise')]
    public function index(Request $request, FranchiseRepository $repository): Response
    {
        //créer une nouvelle entité structure
        $searchFranchise = new FranchiseSearch();
        //Donne lieu à un nouveau formulaire
        $formFranchiseSearch = $this->createForm(FranchiseSearchType::class, $searchFranchise);
        $formFranchiseSearch->handleRequest($request);

        //$data = $repository->findAll();
        $franchises = $this->paginator->paginate(
            $repository->findAllQueries($searchFranchise),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('franchise/index.html.twig', [
            'franchises' => $franchises,
            'franchiseSearchType' => $formFranchiseSearch->createView()
        ]);
    }
    
    #[Route('/details/{id}', name: 'app_detail_franchise')]
    public function detail(Request $request, StructureRepository $repository, StructureSearch $search): Response
    {
        //$data = $structureRepository->findByFranchise($franchise);
        $structures = $this->paginator->paginate(
            $repository->findAllByFranchiseQueries($search),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('franchise/detail_franchise.html.twig', [
            'structures' => $structures
        ]);
    }


/*
    #[Route('/activate/{token', name: 'app_franchise_activation')]
    public function activation_token($token, FranchiseRepository $repository, EntityManagerInterface $entityManager)
    {

        $franchise = $repository->findOneBy([
            'activation_token' => $token
        ]);

        //If no franchise exist
        if (!$franchise){
            //Message send if the Franchise doesn't exist
            throw $this->createNotFoundException("Cette franchise n'existe pas");
        }

        //Delete token
        $franchise->setActivationToken(null);
        $entityManager->persist($franchise);
        $entityManager->flush();

        //generate a message flash
        $this->addFlash('message', 'utilisateur activé avec succès');

        return $this->redirectToRoute('api_home');
    }*/
}
