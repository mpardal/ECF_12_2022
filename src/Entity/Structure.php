<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
class Structure
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
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $fullDescription = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $active = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $venteWhey = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $venteServiette = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $venteBoisson = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $sauna = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $jourPaiement = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $fermetureTardive = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $envoiNewsletter = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $ringBoxe = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $crossfit = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $biking = null;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

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

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getVenteWhey(): ?int
    {
        return $this->venteWhey;
    }

    public function setVenteWhey(int $venteWhey): self
    {
        $this->venteWhey = $venteWhey;

        return $this;
    }

    public function getVenteServiette(): ?int
    {
        return $this->venteServiette;
    }

    public function setVenteServiette(int $venteServiette): self
    {
        $this->venteServiette = $venteServiette;

        return $this;
    }

    public function getVenteBoisson(): ?int
    {
        return $this->venteBoisson;
    }

    public function setVenteBoisson(int $venteBoisson): self
    {
        $this->venteBoisson = $venteBoisson;

        return $this;
    }

    public function getSauna(): ?int
    {
        return $this->sauna;
    }

    public function setSauna(int $sauna): self
    {
        $this->sauna = $sauna;

        return $this;
    }

    public function getJourPaiement(): ?int
    {
        return $this->jourPaiement;
    }

    public function setJourPaiement(int $jourPaiement): self
    {
        $this->jourPaiement = $jourPaiement;

        return $this;
    }

    public function getFermetureTardive(): ?int
    {
        return $this->fermetureTardive;
    }

    public function setFermetureTardive(int $fermetureTardive): self
    {
        $this->fermetureTardive = $fermetureTardive;

        return $this;
    }

    public function getEnvoiNewsletter(): ?int
    {
        return $this->envoiNewsletter;
    }

    public function setEnvoiNewsletter(int $envoiNewsletter): self
    {
        $this->envoiNewsletter = $envoiNewsletter;

        return $this;
    }

    public function getRingBoxe(): ?int
    {
        return $this->ringBoxe;
    }

    public function setRingBoxe(int $ringBoxe): self
    {
        $this->ringBoxe = $ringBoxe;

        return $this;
    }

    public function getCrossfit(): ?int
    {
        return $this->crossfit;
    }

    public function setCrossfit(int $crossfit): self
    {
        $this->crossfit = $crossfit;

        return $this;
    }

    public function getBiking(): ?int
    {
        return $this->biking;
    }

    public function setBiking(int $biking): self
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
}
