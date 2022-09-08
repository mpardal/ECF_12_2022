<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Form\FranchiseSearchType;
use App\Form\StructureSearchType;
use App\Repository\FranchiseRepository;
use App\Repository\StructureRepository;
use App\Search\FranchiseSearch;
use App\Search\StructureSearch;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/structure')]
class StructureController extends AbstractController
{
    public function __construct(private readonly PaginatorInterface  $paginator,
                                private readonly FranchiseRepository $franchiseRepository,
                                private readonly StructureRepository $structureRepository)
    {
    }

    #[Route('/list', name: 'app_list_franchise_by_structure')]
    public function index(Request $request): Response
    {
        // Nouvelle entité FranchiseSearch
        $searchFranchise = new FranchiseSearch();
        // Nouveau formulaire
        $formFranchiseSearch = $this->createForm(FranchiseSearchType::class, $searchFranchise);
        $formFranchiseSearch->handleRequest($request);

        // Pagination
        $franchises = $this->paginator->paginate(
        //Filtre
            $this->franchiseRepository->findAllQueries($searchFranchise),
            // Pagination
            $request->query->getInt('page', 1),
            // Nombre limite d'articles
            6
        );

        // vérification de la requête ajax
        if ($request->query->get('ajax')) {
            if (!$formFranchiseSearch->isValid()) {
                return new JsonResponse([
                    'error' => $this->formErrorToJson($formFranchiseSearch)
                ]);
            }

            return new JsonResponse([
                'content' => $this->renderView('franchise/franchise_list.html.twig', [
                    'franchises' => $franchises,
                    'franchiseSearchType' => $formFranchiseSearch->createView()
                ])
            ]);
        }

        return $this->render('franchise/index.html.twig', [
            'franchises' => $franchises,
            'franchiseSearchType' => $formFranchiseSearch->createView()
        ]);
    }

    #[Route('/details/{id}', name: 'app_detail_franchise_by_structure')]
    public function detail(Request $request, Franchise $franchise): Response
    {
        // Entité StructureSearch
        $search = new StructureSearch();
        // Nouveau formulaire
        $formStructureSearch = $this->createForm(StructureSearchType::class, $search);
        $formStructureSearch->handleRequest($request);
        //Pagination
        $structures = $this->paginator->paginate(
        //Filtre
            $this->structureRepository->findAllByFranchiseQueries($franchise, $search), // TODO: structure search
            //Pagination
            $request->query->getInt('page', 1),
            // Nombre limite d'articles
            6
        );

        // vérification de la requête ajax
        if ($request->query->get('ajax')) {
            if (!$formStructureSearch->isValid()) {
                return new JsonResponse([
                    'error' => $this->formErrorToJson($formStructureSearch)
                ]);
            }
            return new JsonResponse([
                'content' => $this->renderView('structure/detail_structure.html.twig', [
                    'structures' => $structures,
                    'franchise' => $franchise,
                    'structureSearchType' => $formStructureSearch->createView()
                ])
            ]);
        }

        return $this->render('franchise/detail_franchise.html.twig', [
            'structures' => $structures,
            'franchise' => $franchise,
            'structureSearchType' => $formStructureSearch->createView()
        ]);
    }

    private function formErrorToJson(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }

        return $errors;
    }
}
