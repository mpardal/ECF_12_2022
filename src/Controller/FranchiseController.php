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
        $structures = $this->paginator->paginate(
            $repository->findAllByFranchiseQueries($search),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('franchise/detail_franchise.html.twig', [
            'structures' => $structures
        ]);
    }
}
