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
    private ?string $code_postal = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $short_description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $full_description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $active = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $vente_whey = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $vente_serviette = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $vente_boisson = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $sauna = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $jour_paiement = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $fermeture_tardive = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $envoi_newsletter = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $ring_boxe = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $crossfit = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $biking = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Franchise $franchise_id = null;

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
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

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
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getFullDescription(): ?string
    {
        return $this->full_description;
    }

    public function setFullDescription(?string $full_description): self
    {
        $this->full_description = $full_description;

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
        return $this->vente_whey;
    }

    public function setVenteWhey(int $vente_whey): self
    {
        $this->vente_whey = $vente_whey;

        return $this;
    }

    public function getVenteServiette(): ?int
    {
        return $this->vente_serviette;
    }

    public function setVenteServiette(int $vente_serviette): self
    {
        $this->vente_serviette = $vente_serviette;

        return $this;
    }

    public function getVenteBoisson(): ?int
    {
        return $this->vente_boisson;
    }

    public function setVenteBoisson(int $vente_boisson): self
    {
        $this->vente_boisson = $vente_boisson;

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
        return $this->jour_paiement;
    }

    public function setJourPaiement(int $jour_paiement): self
    {
        $this->jour_paiement = $jour_paiement;

        return $this;
    }

    public function getFermetureTardive(): ?int
    {
        return $this->fermeture_tardive;
    }

    public function setFermetureTardive(int $fermeture_tardive): self
    {
        $this->fermeture_tardive = $fermeture_tardive;

        return $this;
    }

    public function getEnvoiNewsletter(): ?int
    {
        return $this->envoi_newsletter;
    }

    public function setEnvoiNewsletter(int $envoi_newsletter): self
    {
        $this->envoi_newsletter = $envoi_newsletter;

        return $this;
    }

    public function getRingBoxe(): ?int
    {
        return $this->ring_boxe;
    }

    public function setRingBoxe(int $ring_boxe): self
    {
        $this->ring_boxe = $ring_boxe;

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
        return $this->franchise_id;
    }

    public function setFranchiseId(?Franchise $franchise_id): self
    {
        $this->franchise_id = $franchise_id;

        return $this;
    }
}
