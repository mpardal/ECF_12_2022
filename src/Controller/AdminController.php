<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Franchise;
use App\Entity\Structure;
use App\Form\AdminRegistrationFormType;
use App\Form\FranchiseRegistrationFormType;
use App\Form\FranchiseSearchType;
use App\Form\StructureRegistrationFormType;
use App\Repository\FranchiseRepository;
use App\Repository\StructureRepository;
use App\Search\FranchiseSearch;
use App\Search\StructureSearch;
use App\Security\AdminAuthenticator;
use App\Security\UserStorage;
use App\Service\FranchiseMails;
use App\Service\StructureMails;
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

#[Route('/admin')]
class AdminController extends AbstractController
{

    public function __construct(private readonly PaginatorInterface $paginator)
    {
    }

    #[Route('/register', name: 'app_register_admin')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AdminAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Admin();
        $form = $this->createForm(AdminRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

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
    public function franchiseNew(FranchiseRepository $franchiseRepository, Request $request,
                                 UserPasswordHasherInterface $userPasswordHasher, FranchiseMails $franchiseMails): Response
    {
        // Vérifie si l'utilisateur à le role admin
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        //créer une nouvelle entité franchise
        $franchise = new Franchise();
        //Donne lieu à un nouveau formulaire
        $formFranchise = $this->createForm(FranchiseRegistrationFormType::class, $franchise);
        $formFranchise->handleRequest($request);

        if ($formFranchise->isSubmitted() && $formFranchise->isValid()) {
            // encode the plain password
            $franchise->setPassword(
                $userPasswordHasher->hashPassword(
                    $franchise,
                    $formFranchise->get('password')->getData()
                )
            );


            $franchiseRepository->add($franchise, true);
            $this->addFlash('success', 'Le nouveau partenaire est créé avec succès');
            // do anything else you need here, like send an email

            $franchiseMails->sendCreated($franchise);

            return $this->redirectToRoute('app_admin_list_franchise');
        }
        return $this->render('franchise/create_franchise.html.twig', [
            //'controller_name' => 'PartnerController',
            'franchise' => $franchise,
            'franchiseRegistrationForm' => $formFranchise->createView(),
        ]);
    }


    // Création d'une structure
    #[Route('/create_structure', name: 'app_admin_create_structure')]
    public function structureNew(StructureRepository $structureRepository, Request $request,
                                 UserPasswordHasherInterface $userPasswordHasher, StructureMails $structureMails): Response
    {
        // Vérifie si l'utilisateur à le role admin
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        //créer une nouvelle entité structure
        $structure = new Structure();
        //Donne lieu à un nouveau formulaire
        $formStructure = $this->createForm(StructureRegistrationFormType::class, $structure);
        $formStructure->handleRequest($request);

        if ($formStructure->isSubmitted() && $formStructure->isValid()) {
            // encode the plain password
            $structure->setPassword(
                $userPasswordHasher->hashPassword(
                    $structure,
                    $formStructure->get('password')->getData()
                )
            );

            $structureRepository->add($structure, true);
            $this->addFlash('success', 'La la nouvelle structure est créé avec succès');
            // do anything else you need here, like send an email

            $structureMails->sendCreated($structure);

            return $this->redirectToRoute('app_admin_list_structure');
        }
        return $this->render('structure/create_structure.html.twig', [
            'controller_name' => 'PartnerController',
            'structureRegistrationForm' => $formStructure->createView(),
        ]);
    }

    //Modification d'une franchise

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    #[Route('/edit_franchise/{id}', name: 'app_admin_edit_franchise')]
    public function editFranchise(Franchise $franchise, Request $request, UserPasswordHasherInterface $userPasswordHasher,
                                  EntityManagerInterface $entityManager, FranchiseMails $franchiseMails): Response
    {
        $formFranchise = $this->createForm(FranchiseRegistrationFormType::class, $franchise);
        $formFranchise->handleRequest($request);
        if ($formFranchise->isSubmitted() && $formFranchise->isValid()) {
            // encode the plain password
            $franchise->setPassword(
                $userPasswordHasher->hashPassword(
                    $franchise,
                    $formFranchise->get('password')->getData()
                )
            );


            $entityManager->flush();
            //$this->addFlash('success', 'Le nouveau partenaire est créé avec succès');
            // do anything else you need here, like send an email

            $franchiseMails->sendEdited($franchise);

            return $this->redirectToRoute('app_admin_list_franchise');

        }
        return $this->render('franchise/edit_franchise.html.twig', [
            //'controller_name' => 'PartnerController',
            'franchise' => $franchise,
            'franchiseRegistrationForm' => $formFranchise->createView()
        ]);
    }



    //Modification d'une structure

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    #[Route('/edit_structure/{id}', name: 'app_admin_edit_structure')]
    public function editStructure(Structure $structure, Request $request, EntityManagerInterface $entityManager,
                                  StructureMails $structureMails): Response
    {
        $formStructure = $this->createForm(StructureRegistrationFormType::class, $structure);
        $formStructure->handleRequest($request);
        if ($formStructure->isSubmitted() && $formStructure->isValid()) {
            // encode the plain password


            $entityManager->flush();
            $this->addFlash('success', 'Le nouveau partenaire est créé avec succès');
            // do anything else you need here, like send an email

           $structureMails->sendEdited($structure);

            return $this->redirectToRoute('app_admin_list_structure');

        }
        return $this->render('structure/edit_structure.html.twig', [
            'controller_name' => 'PartnerController',
            'structure' => $structure,
            'structureRegistrationForm' => $formStructure->createView(),
        ]);
    }

    //Listes des franchises
    #[Route('/list_franchise', name: 'app_admin_list_franchise')]
    public function listFranchise(Request $request, FranchiseRepository $repository): Response
    {
        //créer une nouvelle entité structure
        $search = new FranchiseSearch();
        //Donne lieu à un nouveau formulaire
        $formFranchiseSearch = $this->createForm(FranchiseSearchType::class, $search);
        $formFranchiseSearch->handleRequest($request);

        //Gère la pagination
        $franchises = $this->paginator->paginate(
            $repository->findAllQueries($search),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('franchise/index.html.twig', [
            'franchises' => $franchises,
            'franchiseSearchType' => $formFranchiseSearch->createView()
        ]);
    }

    #[Route('/list_structure', name: 'app_admin_list_structure')]
    public function listStructure(Request $request, FranchiseRepository $repository, FranchiseSearch $search): Response
    {
        $franchises = $this->paginator->paginate(
            $repository->findAllQueries($search),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('franchise/index.html.twig', [
            'franchises' => $franchises
        ]);
    }

    #[Route('/details_franchise/{id}', name: 'app_admin_detail_franchise')]
    public function detail(Request $request, StructureRepository $structureRepository, Franchise $franchise, StructureSearch $search): Response
    {

        //$data = $structureRepository->findByFranchise($franchise);
        $structures = $this->paginator->paginate(
            $structureRepository->findAllByFranchiseQueries($franchise, $search),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('franchise/detail_franchise.html.twig', [
                'structures' => $structures,
                'franchise' => $franchise
            ]
        );
    }
}
