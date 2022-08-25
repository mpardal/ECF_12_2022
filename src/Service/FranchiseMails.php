<?php

namespace App\Service;

use App\Entity\Franchise;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class FranchiseMails
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendCreated(Franchise $franchise)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@sport.fr'))
            ->to($franchise->getEmail())
            ->subject('Création de votre franchise' . $franchise->getName())
            ->htmlTemplate('mail/create_franchise.mjml.twig')
            ->context([
                'franchise' => $franchise
            ]);

        $this->mailer->send($email);
    }

    public function sendEdited(Franchise $franchise)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@sport.fr'))
            ->to($franchise->getEmail())
            ->subject('Modification de votre franchise de ' . $franchise->getName())
            ->htmlTemplate('mail/edit_franchise.mjml.twig')
            ->context([
                'franchise' => $franchise,
            ]);

        $this->mailer->send($email);
    }

    public function returnPassword(Franchise $franchise)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@sport.fr'))
            ->to($franchise->getEmail())
            ->subject("Validation de l'enregistrement de votre mot de passe")
            ->htmlTemplate('mail/password_validate.mjml.twig')
            ->context([
                'franchise' => $franchise,
            ]);

        $this->mailer->send($email);
    }
}