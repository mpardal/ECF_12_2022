<?php

namespace App\Tests\Controller;

use App\Repository\AdminRepository;
use App\Repository\FranchiseRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Mime\RawMessage;

class AdminPageTest extends WebTestCase
{
    public function testAdminCanEditAFranchise()
    {
        $client = static::createClient();
        $this->loginAdmin($client);
        // Requête sur l'url
        $crawler = $client->request('GET', '/admin/list_franchise');
        $this->assertResponseIsSuccessful();
        // On vérifie si l'admin peut modifier une franchise
        $this->assertSelectorTextContains('[data-testid=admin-edit-franchise]', 'Modifier');
    }

    public function testAdminSendMailToFranchiseWhenCreateFranchise()
    {
        $client = static::createClient();

        $this->loginAdmin($client);

        $crawler = $client->request('GET', '/admin/create_franchise');

        $this->assertResponseIsSuccessful();

        $buttonSubmit = $crawler->selectButton('submit');

        $form = $buttonSubmit->form([
            'franchise_registration_form[name]' => 'Fake Franchise',
            'franchise_registration_form[email]' => 'fake@sport.fr',
            'franchise_registration_form[city]' => 'fake',
            'franchise_registration_form[active]' => true,
            'franchise_registration_form[wheySale]' => true,
            'franchise_registration_form[towelSale]' => false,
            'franchise_registration_form[drinkSale]' => false,
            'franchise_registration_form[sauna]' => true,
            'franchise_registration_form[paymentDay]' => true,
            'franchise_registration_form[lateClosing]' => false,
            'franchise_registration_form[sendNewsletter]' => false,
            'franchise_registration_form[ringBoxe]' => true,
            'franchise_registration_form[crossfit]' => false,
            'franchise_registration_form[biking]' => false,
        ]);

        try {
            $client->submit($form);

            $email = $this->getMailerMessage();

            $this->assertEmailCount(1);
            $this->assertEmailAddressContains($email, 'to', 'fake@sport.fr');
        } finally {
            // Supprime la franchise qui a été créée par le submit ci-dessus.
            // `finally` permet de lancer la suppression même si une assertion fail
            $franchiseRepository = $this->getFranchiseRepository();
            $franchise = $franchiseRepository->findOneBy(['email' => 'fake@sport.fr']);

            if ($franchise) {
                $franchiseRepository->remove($franchise, true);
            }
        }
    }

    private function loginAdmin(KernelBrowser $client)
    {
        // Va chercher les informations dans la BDD lié à AdminRepository.
        $adminRepository = static::getContainer()->get(AdminRepository::class);
        // Recherche l'admin dans la BDD par son @mail
        $testAdmin = $adminRepository->findOneBy(['email' => 'admin@sport.fr']);
        // Simule la connexion de l'admin cité précédemment
        $client->loginUser($testAdmin, 'admin_secured_area');
    }

    private function getFranchiseRepository(): FranchiseRepository
    {
        return static::getContainer()->get(FranchiseRepository::class);
    }
}
