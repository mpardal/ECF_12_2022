<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Form\FranchiseRegistrationFormType;
use App\Repository\FranchiseRepository;
use App\Security\FranchiseAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/franchise')]
class FranchiseRegistrationController extends AbstractController
{
    #[Route('/', name: 'app_list_franchise')]
    public function index(FranchiseRepository $repository): Response
    {
        $franchises = $repository->findAll();
        return $this->render('franchise/index.html.twig',
            compact('franchises')
        );
    }

    #[Route('/create', name: 'app_admin_create_franchise')]
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, FranchiseAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $franchise = new Franchise();
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

            $entityManager->persist($franchise);
            $entityManager->flush();
            //$this->addFlash('success', 'Le nouveau partenaire est créé avec succès');
            // do anything else you need here, like send an email

                /*  return $userAuthenticator->authenticateUser(
                       $userFranchise,
                       $authenticator,
                       $request
                   );*/
            return $this->redirectToRoute('app_list_franchise');
        }
        return $this->render('franchise/create_franchise.html.twig', [
            //'controller_name' => 'PartnerController',
            'franchise' => $franchise,
            'franchiseRegistrationForm' => $formFranchise->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_admin_edit_franchise')]
    public function edit(Franchise $franchise, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
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

            return $this->redirectToRoute('app_list_franchise');

        }
        return $this->render('franchise/edit_franchise.html.twig', [
            //'controller_name' => 'PartnerController',
            'franchise' => $franchise,
            'franchiseRegistrationForm' => $formFranchise->createView()
        ]);
    }

    #[Route('/details/{id}', name: 'app_detail_franchise')]
    public function detail(FranchiseRepository $repository): Response
    {
        $franchise = $repository->findAll();
        return $this->render('franchise/detail_franchise.html.twig',
            compact('franchise')
        );
    }
}
