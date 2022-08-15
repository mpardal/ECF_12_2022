<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends AbstractController
{
    #[Route('/partner', name: 'app_partner')]
    public function index(): Response
    {
        return $this->render('partner/index.html.twig', [
            'controller_name' => 'PartnerController',
        ]);
    }


    #[Route('/partner/new', name: 'new_partner')]
    public function new(): Response
    {
        return $this->render('partner/newPartner.html.twig', [
            'controller_name' => 'PartnerController',
        ]);
    }

    #[Route('/partner/edit', name: 'edit_partner')]
    public function modify(): Response
    {
        return $this->render('partner/modifyPartner.html.twig', [
            'controller_name' => 'PartnerController',
        ]);
    }
}
