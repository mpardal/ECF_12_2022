<?php

namespace App\Service;

use App\Entity\Franchise;
use App\Entity\Structure;

class StructureOptionsRegister
{
    public function register(Franchise $franchise, Structure $structure): void
    {
        $structure->setWheySale($franchise->isWheySale());
        $structure->setTowelSale($franchise->isTowelSale());
        $structure->setDrinkSale($franchise->isDrinkSale());
        $structure->setSauna($franchise->isSauna());
        $structure->setPaymentDay($franchise->isPaymentDay());
        $structure->setLateClosing($franchise->isLateClosing());
        $structure->setSendNewsletter($franchise->isSendNewsletter());
        $structure->setRingBoxe($franchise->isRingBoxe());
        $structure->setCrossfit($franchise->isCrossfit());
        $structure->setBiking($franchise->isBiking());
    }
}
