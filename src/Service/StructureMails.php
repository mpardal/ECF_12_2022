<?php

namespace App\Service;

use App\Entity\Structure;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class StructureMails
{
    public function __construct(private readonly MailerInterface $mailer, private readonly Environment $twig)
    {
    }

    public function sendCreated(Structure $structure): void
    {
        $email = (new Email())
            ->from(new Address('no-reply@sport.fr'))
            ->to($structure->getEmail())
            ->cc($structure->getFranchise()->getEmail())
            ->subject('Création de votre structure de ' . $structure->getName())
            ->html(
                $this->twig->render('mail/create_structure.mjml.twig', [
                    'structure' => $structure
                ])
            );

        $this->mailer->send($email);
    }

    public function sendEdited(Structure $structure): void
    {
        $email = (new Email())
            ->from(new Address('no-reply@sport.fr'))
            ->to($structure->getEmail())
            ->cc($structure->getFranchise()->getEmail())
            ->subject('Modification de votre structure de ' . $structure->getName())
            ->html(
                $this->twig->render('mail/edit_structure.mjml.twig', [
                    'structure' => $structure
                ])
            );

        $this->mailer->send($email);
    }

    public function returnPassword(Structure $structure): void
    {
        $email = (new Email())
            ->from(new Address('no-reply@sport.fr'))
            ->to($structure->getEmail())
            ->subject("Validation de l'enregistrement de votre mot de passe")
            ->html(
                $this->twig->render('mail/password_validate.mjml.twig', [
                    'structure' => $structure
                ])
            );

        $this->mailer->send($email);
    }
}