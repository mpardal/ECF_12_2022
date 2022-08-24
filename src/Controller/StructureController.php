<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Repository\FranchiseRepository;
use App\Repository\StructureRepository;
use App\Search\FranchiseSearch;
use App\Search\StructureSearch;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/structure')]
class StructureController extends AbstractController
{
    public function __construct(private readonly PaginatorInterface $paginator)
    {
    }

    #[Route('/', name: 'app_list_structure')]
    public function index(Request $request, FranchiseRepository $repository, FranchiseSearch $search): Response
    {
        $data = $repository->findAll();
        $franchises = $this->paginator->paginate(
            $repository->findAllQueries($search),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('franchise/index.html.twig', [
            'franchises' => $franchises
        ]);
    }

    #[Route('/details/{id}', name: 'app_detail_structure')]
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
}
