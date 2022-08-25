<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Franchise;
use App\Entity\Structure;
use App\Form\AdminRegistrationFormType;
use App\Form\FranchiseRegistrationFormType;
use App\Form\FranchiseSearchType;
use App\Form\StructureRegistrationFormType;
use App\Form\StructureSearchType;
use App\Repository\AdminRepository;
use App\Repository\FranchiseRepository;
use App\Repository\StructureRepository;
use App\Search\FranchiseSearch;
use App\Search\StructureSearch;
use App\Security\AdminAuthenticator;
use App\Security\UserStorage;
use App\Service\FranchiseMails;
use App\Service\StructureMails;
use App\Service\StructureOptionsRegister;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Uid\Uuid;

#[Route('/admin')]
class AdminController extends AbstractController
{

    public function __construct(private readonly PaginatorInterface $paginator)
    {
    }

    #[Route('/register', name: 'app_register_admin')]
    public function register(Request            $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator,
                             AdminAuthenticator $authenticator, EntityManagerInterface $entityManager, AdminRepository $adminRepository): Response
    {
        // créer une nouvelle entité franchise
        $user = new Admin();
        //Donne lieu à un nouveau formulaire
        $form = $this->createForm(AdminRegistrationFormType::class, $user);
        $form->handleRequest($request);

        //Vérification de la bonne complétude et de la validité du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            //encodage du mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //fonction pour flush et persist (dans Repository)
            $adminRepository->add($user, true);


            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('admin/admin_register.html.twig', [
            'AdminRegistrationForm' => $form->createView(),
        ]);
    }


    //Création de la franchise
    #[Route('/create_franchise', name: 'app_admin_create_franchise')]
    public function franchiseNew(FranchiseRepository         $franchiseRepository, Request $request,
                                 UserPasswordHasherInterface $userPasswordHasher, FranchiseMails $franchiseMails): Response
    {
        //créer une nouvelle entité franchise
        $franchise = new Franchise();
        //Donne lieu à un nouveau formulaire
        $formFranchise = $this->createForm(FranchiseRegistrationFormType::class, $franchise);
        $formFranchise->handleRequest($request);

        //Vérification de la bonne complétude et de la validité du formulaire
        if ($formFranchise->isSubmitted() && $formFranchise->isValid()) {
            //initialisation mot de passe encodé
            $franchise->setPasswordToken(Uuid::v4());
            //fonction pour flush et persist (dans Repository)
            $franchiseRepository->add($franchise, true);
            //Annonce pour validation de création
            $this->addFlash('success', 'Le nouveau partenaire est créé avec succès');

            //Création et envoi du mail du mail
            $franchiseMails->sendCreated($franchise);

            //redirection après validation du formulaire
            return $this->redirectToRoute('app_admin_list_franchise');
        }
        return $this->render('franchise/create_franchise.html.twig', [
            'franchise' => $franchise,
            'franchiseRegistrationForm' => $formFranchise->createView(),
        ]);
    }


    // Création d'une structure
    #[Route('/create_structure', name: 'app_admin_create_structure')]
    public function structureNew(StructureRepository $structureRepository, Request $request, FranchiseMails $franchiseMails, StructureOptionsRegister $structureOptionsRegister): Response
    {
        //créer une nouvelle entité structure
        $structure = new Structure();
        //Donne lieu à un nouveau formulaire
        $formStructure = $this->createForm(StructureRegistrationFormType::class, $structure);
        $formStructure->handleRequest($request);

        //Vérification de la bonne complétude et de la validité du formulaire
        if ($formStructure->isSubmitted() && $formStructure->isValid()) {
            // initialisation mot de passe encodé
            // fonction pour flush et persist (dans Repository)

            // enregistre les options par défaut de la franchise sur la structure
            $structureOptionsRegister->register($structure->getFranchise(), $structure);

            $structureRepository->add($structure, true);
            // Annonce pour validation de création
            $this->addFlash('success', 'La nouvelle structure est créée avec succès');

            // Création et envoi du mail du mail
            $franchiseMails->sendStructureCreated($structure->getFranchise(), $structure);

            //redirection après validation du formulaire
            return $this->redirectToRoute('app_admin_list_franchise');
        }
        return $this->render('structure/create_structure.html.twig', [
            'structureRegistrationForm' => $formStructure->createView(),
        ]);
    }

    //Modification d'une franchise

    #[Route('/edit_franchise/{id}', name: 'app_admin_edit_franchise')]
    public function editFranchise(Franchise $franchise, Request $request, EntityManagerInterface $entityManager,
                                  FranchiseMails $franchiseMails): Response
    {
        //Donne lieu à un nouveau formulaire
        $formFranchise = $this->createForm(FranchiseRegistrationFormType::class, $franchise);
        $formFranchise->handleRequest($request);

        //Vérification de la bonne complétude et de la validité du formulaire
        if ($formFranchise->isSubmitted() && $formFranchise->isValid()) {
            // Enregistre les données dans la BDD
            $entityManager->flush();
            // Annonce pour validation de modification
            $this->addFlash('success', 'La franchise a été modifiée avec succès');

            // Création et envoi du mail du mail
            $franchiseMails->sendEdited($franchise);

            // redirection après validation du formulaire
            return $this->redirectToRoute('app_admin_list_franchise');

        }
        return $this->render('franchise/edit_franchise.html.twig', [
            'franchise' => $franchise,
            'franchiseRegistrationForm' => $formFranchise->createView()
        ]);
    }


    //Modification d'une structure

    #[Route('/edit_structure/{id}', name: 'app_admin_edit_structure')]
    public function editStructure(Structure      $structure, Request $request, EntityManagerInterface $entityManager,
                                  StructureMails $structureMails): Response
    {
        //Donne lieu à un nouveau formulaire
        $formStructure = $this->createForm(StructureRegistrationFormType::class, $structure);
        $formStructure->handleRequest($request);

        //Vérification de la bonne complétude et de la validité du formulaire
        if ($formStructure->isSubmitted() && $formStructure->isValid()) {

            //Enregistre les données dans la BDD
            $entityManager->flush();
            //Annonce pour validation de modification
            $this->addFlash('success', 'Le nouveau partenaire est créé avec succès');
            // do anything else you need here, like send an email

            //Création et envoi du mail du mail
            $structureMails->sendEdited($structure);

            //redirection après validation du formulaire
            return $this->redirectToRoute('app_admin_list_structure');

        }
        return $this->render('structure/edit_structure.html.twig', [
            'structure' => $structure,
            'structureRegistrationForm' => $formStructure->createView(),
        ]);
    }

    //Listes des franchises
    #[Route('/list_franchise', name: 'app_admin_list_franchise')]
    public function listFranchise(Request $request, FranchiseRepository $repository): Response
    {
        // Nouvelle entité FranchiseSearch
        $search = new FranchiseSearch();
        //Donne lieu à un nouveau formulaire
        $formFranchiseSearch = $this->createForm(FranchiseSearchType::class, $search);
        $formFranchiseSearch->handleRequest($request);

        //pagination et affichage d'une franchise et de ces structures.
        $franchises = $this->paginator->paginate(
        //fonction permettant de créer une barre de recherche
            $repository->findAllQueries($search),
            //initialisation de la pagination
            $request->query->getInt('page', 1),
            //Nombre d'articles par page
            6
        );
        return $this->render('franchise/index.html.twig', [
            'franchises' => $franchises,
            'franchiseSearchType' => $formFranchiseSearch->createView()
        ]);
    }

    #[Route('/details_franchise/{id}', name: 'app_admin_detail_franchise')]
    public function detail(Request $request, StructureRepository $structureRepository, Franchise $franchise, StructureSearch $search): Response
    {
        // Entité StructureSearch
        $search = new StructureSearch();
        // Nouveau formulaire
        $formStructureSearch = $this->createForm(StructureSearchType::class, $search);
        $formStructureSearch->handleRequest($request);

        //pagination et affichage d'une franchise et de ces structures.
        $structures = $this->paginator->paginate(
        //fonction permettant de créer une barre de recherche
            $structureRepository->findAllByFranchiseQueries($franchise, $search),
            //initialisation de la pagination
            $request->query->getInt('page', 1),
            //Nombre d'articles par page
            6
        );
        return $this->render('franchise/detail_franchise.html.twig', [
                'structures' => $structures,
                'franchise' => $franchise,
                'structureSearchType' => $formStructureSearch->createView()
            ]
        );
    }
}
