<?php

namespace App\Security;

use App\Entity\Admin;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserStorage
{
    public function __construct(private readonly TokenStorageInterface $tokenStorageInterface)
    {
    }

    public function getUser(): Admin
    {
        $user = $this->tokenStorageInterface->getToken()->getUser();

        if ($user instanceof Admin){
            return $user;
        }
        throw new \TypeError("You are not an admin");
    }
}