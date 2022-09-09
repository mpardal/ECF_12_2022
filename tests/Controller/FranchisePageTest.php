<?php

namespace App\Tests\Controller;

use App\Repository\FranchiseRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FranchisePageTest extends WebTestCase
{
    public function testFranchiseCannotEditAFranchise()
    {
        $client = static::createClient();
        // Va chercher les informations dans la BDD lié à FranchiseRepository.
        $franchiseRepository = static::getContainer()->get(FranchiseRepository::class);
        // Recherche la franchise dans la BDD par son @mail
        $testAdmin = $franchiseRepository->findOneBy(['email' => 'nantes@sport.fr']);
        // Simule la connexion de la franchise citée précédemment
        $client->loginUser($testAdmin, 'franchise_secured_area');

        $crawler = $client->request('GET', '/franchise/list');
        $this->assertResponseIsSuccessful();
        // On vérifie si la franchise n'a pas accès au bouton d'édition
        $this->assertSelectorNotExists('[data-testid=admin-edit-franchise]');
    }
}