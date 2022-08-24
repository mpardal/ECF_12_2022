<?php

namespace App\Controller;

use App\Form\CreatePasswordFormType;
use App\Repository\FranchiseRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/franchise')]
class FranchiseSecurityController extends AbstractController
{
    #[Route(path: '/connect', name: 'app_franchise_connect')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('franchise/connect_franchise.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error]);
    }

    #[Route(path: '/disconnect', name: 'app_logout_franchise')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
