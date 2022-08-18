<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/partner')]
class PartnerController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('partner/index.html.twig', [
            'controller_name' => 'PartnerController',
        ]);
    }


}
