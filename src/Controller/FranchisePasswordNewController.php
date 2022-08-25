<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Form\FranchisePasswordNewFormType;
use App\Service\FranchiseMails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class FranchisePasswordNewController extends AbstractController
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher,
                                private readonly EntityManagerInterface $entityManager,
                                private readonly FranchiseMails $franchiseMails)
    {
    }

    #[Route('/franchise/new-password/{passwordToken}', name: 'app_franchise_password_new')]
    public function newPassword(Franchise $franchise, Request $request): Response
    {
        // fait le formulaire de mot de passe
        $form = $this->createForm(FranchisePasswordNewFormType::class, $franchise);
        $form->handleRequest($request);
        // Vérifie si le formulaire rempli est soumis et valide
        $plainPassword = $form->get('plainPassword')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $franchise->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $franchise,
                    $$plainPassword
                )
            );
            // Supprime le token de la structure
            $franchise->setPassword(null);
            // envoie dans la base de données
            $this->entityManager->flush();


            // Envoie le mail pour valider la prise en compte du mdp
            $this->franchiseMails->returnPassword($franchise);

            // je redirige vers une page "mot de passe validé"
            return $this->redirectToRoute('app_franchise_password_validated');
        }

        // je rend le formulaire pour le mot de passe
        return $this->render('franchise_password_new/franchise_form_new_password.html.twig', [
            'use_nav' => false,
            'franchisePasswordNew' => $form->createView()
        ]);
    }

    #[Route('/franchise/password-validated', name: 'app_franchise_password_validated', methods: 'GET')]
    public function passwordValidated(): Response
    {
        return $this->render('franchise_password_new/index.html.twig', []);
    }
}
