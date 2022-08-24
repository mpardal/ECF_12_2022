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
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
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
    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    #[Route('/create_franchise', name: 'app_admin_create_franchise')]
    public function franchiseNew(FranchiseRepository $franchiseRepository, Request $request, UserStorage $userStorage,
                        UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer, Admin $admin): Response
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
            //Génère le token et l'enregistre
            //$franchise->setActivationToken(md5(uniqid()));


            $franchiseRepository->add($franchise, true);
            $this->addFlash('success', 'Le nouveau partenaire est créé avec succès');
            // do anything else you need here, like send an email
            $admin = $userStorage->getUser();

            // Crée l'email
            $email = (new TemplatedEmail())
                ->from(new Address('admin@sport.fr'))
                ->to($franchise->getEmail())
                ->subject('Création de votre franchise'.$franchise->getName())
                ->htmlTemplate('mail/create_franchise.mjml.twig')
                ->context([
                    'franchise' => $franchise
                ]);

            $mailer->send($email);

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
    public function structureNew(StructureRepository $structureRepository, Request $request, UserStorage $userStorage,
                                 UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer): Response
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
            $admin = $userStorage->getUser();

            $email = (new TemplatedEmail())
                ->from(new Address($admin->getEmail(), 'Administrateur'))
                ->to($structure->getEmail())
                ->cc($structure->getFranchise()->getEmail())
                ->subject('Création de votre structure de '.$structure->getName())
                ->htmlTemplate('mail/create_structure.mjml.twig')
                ->context([
                    'structure' => $structure
                ]);
            $mailer->send($email);

            return $this->redirectToRoute('app_list_structure');
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
    public function editFranchise(Franchise $franchise, Admin $admin, Request $request, UserPasswordHasherInterface $userPasswordHasher,
                         EntityManagerInterface $entityManager, MailerInterface $mailer): Response
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

            $email = (new TemplatedEmail())
                ->from(new Address($admin->getEmail(), 'Administrateur'))
                ->to($franchise->getEmail())
                ->subject('Modification de votre structure de '.$franchise->getName())
                ->htmlTemplate('mail/edit_franchise.mjml.twig')
                ->context([
                    'franchise' => $franchise
                ]);

            $mailer->send($email);

            return $this->redirectToRoute('app_list_franchise');

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
    public function editStructure(Structure $structure, Admin $admin, Request $request,
                                  EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $formStructure = $this->createForm(StructureRegistrationFormType::class, $structure);
        $formStructure->handleRequest($request);
        if ($formStructure->isSubmitted() && $formStructure->isValid()) {
            // encode the plain password


            $entityManager->flush();
            $this->addFlash('success', 'Le nouveau partenaire est créé avec succès');
            // do anything else you need here, like send an email

            $email = (new TemplatedEmail())
                ->from(new Address($admin->getEmail(), 'Administrateur'))
                ->to($structure->getEmail())
                ->cc($structure->getFranchise()->getEmail())
                ->subject('Modification de votre structure de '.$structure->getName())
                ->htmlTemplate('mail/edit_structure.mjml.twig')
                ->context([
                    'structure' => $structure
                ]);
            $mailer->send($email);

            return $this->redirectToRoute('app_list_structure');

        }
        return $this->render('structure/edit_structure.html.twig', [
            'controller_name' => 'PartnerController',
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


        //$data = $repository->findAll();
        $franchises = $this->paginator->paginate(
            $repository->findAllQueries($search),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('franchise/index.html.twig',[
            'franchises' => $franchises,
            'franchiseSearchType' => $formFranchiseSearch->createView()
        ]);
    }

    #[Route('/list_structure', name: 'app_list_structure')]
    public function listStructure(Request $request, FranchiseRepository $repository, FranchiseSearch $search): Response
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

    #[Route('/details/{id}', name: 'app_admin_detail_franchise')]
    public function detail(Request $request, StructureRepository $structureRepository, StructureSearch $search): Response
    {

        //$data = $structureRepository->findByFranchise($franchise);
        $structures = $this->paginator->paginate(
            $structureRepository->findAllQueries($search),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('franchise/detail_franchise.html.twig',[
                'structures' => $structures
            ]
        );
    }
}
