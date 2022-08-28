<?php

namespace App\Controller;


use App\Entity\Franchise;
use App\Form\FranchiseSearchType;
use App\Form\StructureSearchType;
use App\Repository\FranchiseRepository;
use App\Repository\StructureRepository;
use App\Search\FranchiseSearch;
use App\Search\StructureSearch;
use App\Service\StructureMails;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/franchise')]
class FranchiseController extends AbstractController
{
    public function __construct(private readonly PaginatorInterface     $paginator,
                                private readonly FranchiseRepository    $franchiseRepository,
                                private readonly StructureRepository    $structureRepository,
                                private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/list', name: 'app_list_franchise')]
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
            // Nombre d'articles
            6
        );
        return $this->render('franchise/index.html.twig', [
            'franchises' => $franchises,
            'franchiseSearchType' => $formFranchiseSearch->createView()
        ]);
    }

    #[Route('/details/{id}', name: 'app_detail_franchise')]
    public function detail(Request $request, Franchise $franchise): Response
    {
        //entité StructureSearch
        $search = new StructureSearch();
        // Nouveau formulaire
        $formStructureSearch = $this->createForm(StructureSearchType::class, $search);
        $formStructureSearch->handleRequest($request);

        //Pagination
        $structures = $this->paginator->paginate(
        //Filtre
            $this->structureRepository->findAllByFranchiseQueries($franchise, $search),
            //Pagination
            $request->query->getInt('page', 1),
            // Nombre limite d'articles
            6
        );
        return $this->render('franchise/detail_franchise.html.twig', [
            'structures' => $structures,
            'franchise' => $franchise,
            'structureSearchType' => $formStructureSearch->createView()
        ]);
    }

    #[Route('/validate_structure/{franchiseId}/{structureId}', name: 'app_franchise_validate_structure')]
    public function validationStructure(int $franchiseId, int $structureId, StructureMails $structureMails): Response
    {
        $franchise = $this->franchiseRepository->find($franchiseId);

        // Si franchise est null alors on redirige
        if (null === $franchise) {
            return $this->redirectToRoute('app_list_franchise');
        }

        $structure = $this->structureRepository->find($structureId);
        // Si structure est null alors on redirige
        if (null === $structure) {
            return $this->redirectToRoute('app_list_franchise');
        }
        // Si l'ID de la franchise appartenant à la structure est équivalent à la franchise validant le mail
        if ($structure->getFranchise()->getId() !== $franchiseId) {
            // soit redirection, soit erreur d'accès 403
            throw $this->createAccessDeniedException();
        }
        //Validation de la bonne franchise, Envoi du mdp encodé
        $structure
            ->setFranchiseValidated(true)
            ->setPasswordToken(Uuid::v4());
        //Envoi de mail
        $structureMails->sendCreated($structure);
        //stockage en BDD
        $this->entityManager->flush();
        // Redirection de la route
        return $this->redirectToRoute('app_list_franchise');
    }

}
