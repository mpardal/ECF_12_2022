<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Structure implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $fullDescription = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column]
    private ?bool $wheySale = null;

    #[ORM\Column]
    private ?bool $towelSale = null;

    #[ORM\Column]
    private ?bool $drinkSale = null;

    #[ORM\Column]
    private ?bool $sauna = null;

    #[ORM\Column]
    private ?bool $paymentDay = null;

    #[ORM\Column]
    private ?bool $lateClosing = null;

    #[ORM\Column]
    private ?bool $sendNewsletter = null;

    #[ORM\Column]
    private ?bool $ringBoxe = null;

    #[ORM\Column]
    private ?bool $crossfit = null;

    #[ORM\Column]
    private ?bool $biking = null;

    #[ORM\Column]
    private ?array $roles = [];

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Franchise $franchiseId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getFullDescription(): ?string
    {
        return $this->fullDescription;
    }

    public function setFullDescription(?string $fullDescription): self
    {
        $this->fullDescription = $fullDescription;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getWheySale(): ?bool
    {
        return $this->wheySale;
    }

    public function setWheySale(bool $wheySale): self
    {
        $this->wheySale = $wheySale;

        return $this;
    }

    public function getTowelSale(): ?bool
    {
        return $this->towelSale;
    }

    public function setTowelSale(bool $towelSale): self
    {
        $this->towelSale = $towelSale;

        return $this;
    }

    public function getDrinkSale(): ?bool
    {
        return $this->drinkSale;
    }

    public function setDrinkSale(bool $drinkSale): self
    {
        $this->drinkSale = $drinkSale;

        return $this;
    }

    public function getSauna(): ?bool
    {
        return $this->sauna;
    }

    public function setSauna(bool $sauna): self
    {
        $this->sauna = $sauna;

        return $this;
    }

    public function getPaymentDay(): ?bool
    {
        return $this->paymentDay;
    }

    public function setPaymentDay(bool $paymentDay): self
    {
        $this->paymentDay = $paymentDay;

        return $this;
    }

    public function getLateClosing(): ?bool
    {
        return $this->lateClosing;
    }

    public function setLateClosing(bool $lateClosing): self
    {
        $this->lateClosing = $lateClosing;

        return $this;
    }

    public function getSendNewsletter(): ?bool
    {
        return $this->sendNewsletter;
    }

    public function setSendNewsletter(bool $sendNewsletter): self
    {
        $this->sendNewsletter = $sendNewsletter;

        return $this;
    }

    public function getRingBoxe(): ?bool
    {
        return $this->ringBoxe;
    }

    public function setRingBoxe(bool $ringBoxe): self
    {
        $this->ringBoxe = $ringBoxe;

        return $this;
    }

    public function getCrossfit(): ?bool
    {
        return $this->crossfit;
    }

    public function setCrossfit(bool $crossfit): self
    {
        $this->crossfit = $crossfit;

        return $this;
    }

    public function getBiking(): ?bool
    {
        return $this->biking;
    }

    public function setBiking(bool $biking): self
    {
        $this->biking = $biking;

        return $this;
    }

    public function getFranchiseId(): ?Franchise
    {
        return $this->franchiseId;
    }

    public function setFranchiseId(?Franchise $franchiseId): self
    {
        $this->franchiseId = $franchiseId;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
