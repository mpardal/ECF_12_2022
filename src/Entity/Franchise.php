<?php

namespace App\Entity;

use App\Repository\FranchiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: FranchiseRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Vous avez déjà un compte avec cette adresse email')]
#[Vich\Uploadable]
class Franchise implements UserInterface, PasswordAuthenticatedUserInterface
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
    private ?string $city = null;

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

    #[Vich\UploadableField(mapping: 'sport_gym', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'franchise', targetEntity: Structure::class, orphanRemoval: true)]
    private Collection $structures;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $activationToken = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $passwordToken = null;

    public function __construct()
    {
        $this->structures = new ArrayCollection();
        $this->updatedAt = new \DateTimeImmutable();
    }

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

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return Franchise
     */
    public function setCity(?string $city): Franchise
    {
        $this->city = $city;
        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function isWheySale(): ?bool
    {
        return $this->wheySale;
    }

    public function setWheySale(bool $wheySale): self
    {
        $this->wheySale = $wheySale;

        return $this;
    }

    public function isTowelSale(): ?bool
    {
        return $this->towelSale;
    }

    public function setTowelSale(bool $towelSale): self
    {
        $this->towelSale = $towelSale;

        return $this;
    }

    public function isDrinkSale(): ?bool
    {
        return $this->drinkSale;
    }

    public function setDrinkSale(bool $drinkSale): self
    {
        $this->drinkSale = $drinkSale;

        return $this;
    }

    public function isSauna(): ?bool
    {
        return $this->sauna;
    }

    public function setSauna(bool $sauna): self
    {
        $this->sauna = $sauna;

        return $this;
    }

    public function isPaymentDay(): ?bool
    {
        return $this->paymentDay;
    }

    public function setPaymentDay(bool $paymentDay): self
    {
        $this->paymentDay = $paymentDay;

        return $this;
    }

    public function isLateClosing(): ?bool
    {
        return $this->lateClosing;
    }

    public function setLateClosing(bool $lateClosing): self
    {
        $this->lateClosing = $lateClosing;

        return $this;
    }

    public function isSendNewsletter(): ?bool
    {
        return $this->sendNewsletter;
    }

    public function setSendNewsletter(bool $sendNewsletter): self
    {
        $this->sendNewsletter = $sendNewsletter;

        return $this;
    }

    public function isRingBoxe(): ?bool
    {
        return $this->ringBoxe;
    }

    public function setRingBoxe(bool $ringBoxe): self
    {
        $this->ringBoxe = $ringBoxe;

        return $this;
    }

    public function isCrossfit(): ?bool
    {
        return $this->crossfit;
    }

    public function setCrossfit(bool $crossfit): self
    {
        $this->crossfit = $crossfit;

        return $this;
    }

    public function isBiking(): ?bool
    {
        return $this->biking;
    }

    public function setBiking(bool $biking): self
    {
        $this->biking = $biking;

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure)) {
            $this->structures->add($structure);
            $structure->setFranchise($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getFranchise() === $this) {
                $structure->setFranchise(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_FRANCHISE';

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

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Franchise
     */
    public function setImageFile(?File $imageFile): Franchise
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param string|null $imageName
     * @return Franchise
     */
    public function setImageName(?string $imageName): Franchise
    {
        $this->imageName = $imageName;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     * @return Franchise
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): Franchise
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function setActivationToken(?string $activationToken): self
    {
        $this->activationToken = $activationToken;

        return $this;
    }

    public function getPasswordToken(): ?string
    {
        return $this->passwordToken;
    }

    public function setPasswordToken(?string $passwordToken): self
    {
        $this->passwordToken = $passwordToken;

        return $this;
    }


}
