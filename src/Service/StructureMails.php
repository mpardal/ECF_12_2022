<?php

namespace App\Service;

use App\Entity\Structure;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class StructureMails
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendCreated(Structure $structure)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@sport.fr'))
            ->to($structure->getEmail())
            ->cc($structure->getFranchise()->getEmail())
            ->subject('Création de votre structure de ' . $structure->getName())
            ->htmlTemplate('mail/create_structure.mjml.twig')
            ->context([
                'structure' => $structure
            ]);
        $this->mailer->send($email);
    }

    public function sendEdited(Structure $structure)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@sport.fr'))
            ->to($structure->getEmail())
            ->cc($structure->getFranchise()->getEmail())
            ->subject('Modification de votre structure de ' . $structure->getName())
            ->htmlTemplate('mail/edit_structure.mjml.twig')
            ->context([
                'structure' => $structure
            ]);
        $this->mailer->send($email);
    }
}