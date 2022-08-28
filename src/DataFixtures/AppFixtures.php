<?php

namespace App\DataFixtures;

use App\Entity\Franchise;
use App\Entity\Structure;
use App\Service\StructureOptionsRegister;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher,
                                private readonly StructureOptionsRegister    $structureOptionsRegister)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $franchise = $this->createFranchise('Nantes', 'nantes@sport.fr', 'Nantes', true, false, false, false, true, true, false, false, false, true);
        $franchise1 = $this->createFranchise('Marseille', 'marseilles@sport.fr','Marseille', false, false, true, false, true, false, false, false, true, false);

        $structure = $this->createStructure('Nantes Moulin', 'nantes.moulin@sport.fr', '20 boulevard Jean Moulin', '44100', 'Nantes');
        $structure1 = $this->createStructure('Nantes Erdre', 'nantes.erdre@sport.fr', "20 rue de l'Erdre", '44300', 'Nantes');

        $this->structureOptionsRegister->register($franchise, $structure); // manquait la structure1
        $this->structureOptionsRegister->register($franchise, $structure1);

        $franchise->addStructure($structure);
        $franchise->addStructure($structure1);

        $manager->persist($franchise);
        $manager->persist($franchise1);
        $manager->persist($structure);
        $manager->persist($structure1);

        $manager->flush();
    }

    private function createFranchise(string $name, string $email, string $city, bool $whey, bool $towel, bool $drink,
                                     bool $sauna, bool   $payment, bool $lateClosing, bool $newsletter, bool $boxe,
                                     bool $crossfit, bool   $biking): Franchise
    {
        $franchise = new Franchise();
        $franchise->setName($name)
            ->setPassword($this->passwordHasher->hashPassword($franchise, 'azerty44'))
            ->setEmail($email)
            ->setCity($city)
            ->setActive(true)
            ->setWheySale($whey)
            ->setTowelSale($towel)
            ->setDrinkSale($drink)
            ->setSauna($sauna)
            ->setPaymentDay($payment)
            ->setLateClosing($lateClosing)
            ->setSendNewsletter($newsletter)
            ->setRingBoxe($boxe)
            ->setCrossfit($crossfit)
            ->setBiking($biking);

        return $franchise;
    }

    private function createStructure(string $name, string $email, string $address, string $postalCode, string $city): Structure
    {
        $structure = new Structure();
        $structure->setName($name)
            ->setPassword($this->passwordHasher->hashPassword($structure, 'azerty44'))
            ->setEmail($email)
            ->setAddress($address)
            ->setPostalCode($postalCode)
            ->setCity($city)
            ->setActive(true)
            ->setFranchiseValidated(true);

        return $structure;
    }
}
