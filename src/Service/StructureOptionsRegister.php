<?php

namespace App\Service;

use App\Entity\Franchise;
use App\Entity\Structure;

class StructureOptionsRegister
{
    public function register(Franchise $franchise, Structure $structure): void
    {
        $structure->setWheySale($franchise->getWheySale());
        $structure->setTowelSale($franchise->getTowelSale());
        $structure->setDrinkSale($franchise->getDrinkSale());
        $structure->setSauna($franchise->getSauna());
        $structure->setPaymentDay($franchise->getPaymentDay());
        $structure->setLateClosing($franchise->getLateClosing());
        $structure->setSendNewsletter($franchise->getSendNewsletter());
        $structure->setRingBoxe($franchise->getRingBoxe());
        $structure->setCrossfit($franchise->getCrossfit());
        $structure->setBiking($franchise->getBiking());
    }
}
