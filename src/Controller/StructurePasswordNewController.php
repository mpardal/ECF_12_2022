<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Form\StructurePasswordNewFormType;
use App\Service\StructureMails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class StructurePasswordNewController extends AbstractController
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher,
                                private readonly EntityManagerInterface      $entityManager,
                                private readonly StructureMails              $structureMails)
    {
    }

    #[Route('/structure/new-password/{passwordToken}', name: 'app_structure_password_new', methods: ['GET', 'POST'])]
    public function newPassword(Structure $structure, Request $request): Response
    {
        if (!$structure->isFranchiseValidated()) {
            throw $this->createAccessDeniedException();
        }

        // fait le formulaire de mot de passe
        $form = $this->createForm(StructurePasswordNewFormType::class, $structure);
        $form->handleRequest($request);
        // Vérifie si le formulaire rempli est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // $structure->setPassword(...hasher le password) de la structure
            $plainPassword = $form->get('plainPassword')->getData();
            $structure->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $structure,
                    $plainPassword
                )
            );

            // Supprime le token de la structure, à faire avant le flush
            $structure->setPasswordToken(null);

            // envoie dans la base de données
            $this->entityManager->flush();

            // Envoie le mail pour notifier la prise en compte du mdp
            $this->structureMails->returnPassword($structure);

            // je redirige vers une page "mot de passe validé"
            return $this->redirectToRoute('app_structure_password_validated');
        }

        // je rend le formulaire pour le mot de passe
        return $this->render('structure_password_new/structure_form_new_password.html.twig', [
            'use_nav' => false,
            'structurePasswordNew' => $form->createView()
        ]);
    }

    #[Route('/structure/password-validated', name: 'app_structure_password_validated', methods: 'GET')]
    public function passwordValidated(): Response
    {
        return $this->render('structure_password_new/index.html.twig', []);
    }
}
