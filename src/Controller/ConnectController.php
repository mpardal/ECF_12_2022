<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ConnectController extends AbstractController
{
    #[Route(path: '/connects', name: 'app_connects')]
    public function login(AuthenticationUtils $authenticationUtilsFranchise, AuthenticationUtils $authenticationUtilsStructure): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $errorFranchise = $authenticationUtilsFranchise->getLastAuthenticationError();
        // last username entered by the user
        $lastUsernameFranchise = $authenticationUtilsFranchise->getLastUsername();


        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $errorStructure = $authenticationUtilsStructure->getLastAuthenticationError();
        // last username entered by the user
        $lastUsernameStructure = $authenticationUtilsStructure->getLastUsername();

        return $this->render('connects/index.html.twig', [
            'last_username_franchise' => $lastUsernameFranchise,
            'error_franchise' => $errorFranchise,
            'last_username_structure' => $lastUsernameStructure,
            'error_structure' => $errorStructure]);
    }

    #[Route(path: '/disconnect', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
