<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailController extends AbstractController
{
    #[Route('/mail', name: 'app_mail')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('admin@test.fr')
            ->to($franchise)
            ->subject('Time for Symfony Mailer!')
            ->htmlTemplate('mail/test_mail.html.twig')
            ->context([
                'franchise' => $franchise
            ]);
       /*return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);*/
    }
}
