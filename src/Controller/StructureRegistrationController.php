<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Form\StructureRegistrationFormType;
use App\Repository\StructureRepository;
use App\Security\StructureAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/structure')]
class StructureRegistrationController extends AbstractController
{
    #[Route('/', name: 'app_list_structure')]
    public function index(StructureRepository $repository): Response
    {
        $structures = $repository->findAll();
        return $this->render('structure/index.html.twig',
            compact('structures')
        );
    }


    #[Route('/create', name: 'app_admin_create_structure')]
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, StructureAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $structure = new Structure();
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

            $entityManager->persist($structure);
            $entityManager->flush();
            $this->addFlash('success', 'Le nouveau partenaire est créé avec succès');
            // do anything else you need here, like send an email

            /*       return $userAuthenticator->authenticateUser(
                       $franchise,
                       $authenticator,
                       $request
                   );*/
            return $this->redirectToRoute('app_list_structure');
        }
        return $this->render('structure/create_structure.html.twig', [
            'controller_name' => 'PartnerController',
            'structureRegistrationForm' => $formStructure->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_admin_edit_structure')]
    public function edit(Structure $structure, Request $request, EntityManagerInterface $entityManager): Response
    {
        $formStructure = $this->createForm(StructureRegistrationFormType::class, $structure);
        $formStructure->handleRequest($request);
        if ($formStructure->isSubmitted() && $formStructure->isValid()) {
            // encode the plain password

            $entityManager->flush();
            $this->addFlash('success', 'Le nouveau partenaire est créé avec succès');
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_list_structure');

        }
        return $this->render('structure/edit_structure.html.twig', [
            'controller_name' => 'PartnerController',
            'structureRegistrationForm' => $formStructure->createView(),
        ]);
    }

    #[Route('/details/{id}', name: 'app_detail_structure')]
    public function detail(StructureRepository $repository): Response
    {
        $structure = $repository->findAll();
        return $this->render('structure/detail_structure.html.twig',
            compact('structure')
        );
    }
}
