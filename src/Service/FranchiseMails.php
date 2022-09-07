<?php

namespace App\Service;

use App\Entity\Franchise;
use App\Entity\Structure;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class FranchiseMails
{
    public function __construct(private readonly MailerInterface $mailer, private readonly Environment $twig)
    {
    }

    public function sendCreated(Franchise $franchise)
    {
        $email = (new Email())
            ->from(new Address('no-reply@sport.fr'))
            ->to($franchise->getEmail())
            ->subject('Création de votre franchise ' . $franchise->getName())
            ->html(
                $this->twig->render('mail/create_franchise.mjml.twig', [
                    'franchise' => $franchise
                ])
            );

        $this->mailer->send($email);
    }

    public function sendEdited(Franchise $franchise)
    {
        $email = (new Email())
            ->from(new Address('no-reply@sport.fr'))
            ->to($franchise->getEmail())
            ->subject('Modification de votre franchise de ' . $franchise->getName())
            ->html(
                $this->twig->render('mail/edit_franchise.mjml.twig', [
                    'franchise' => $franchise,
                ])
            );

        $this->mailer->send($email);
    }

    public function sendStructureCreated(Franchise $franchise, Structure $structure)
    {
        $email = (new Email())
            ->from(new Address('no-reply@sport.fr'))
            ->to($franchise->getEmail())
            ->subject("La structure {$structure->getName()} vient d'être créée")
            ->html(
                $this->twig->render('mail/franchise_new_structure.mjml.twig', [
                    'franchise' => $franchise,
                    'structure' => $structure
                ])
            );

        $this->mailer->send($email);
    }

    public function returnPassword(Franchise $franchise)
    {
        $email = (new Email())
            ->from(new Address('no-reply@sport.fr'))
            ->to($franchise->getEmail())
            ->subject("Validation de l'enregistrement de votre mot de passe")
            ->html(
                $this->twig->render('mail/password_validate.mjml.twig', [
                    'franchise' => $franchise
                ])
            );

        $this->mailer->send($email);
    }
}