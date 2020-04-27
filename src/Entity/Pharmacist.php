<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PharmacistRepository")
 */
class Pharmacist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $certificate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pharmacy_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="infoPharmacist", cascade={"persist", "remove"})
     */
    private $pharmacistUser;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    private $fichier;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCertificate(): ?string
    {
        return $this->certificate;
    }

    public function setCertificate(string $certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function getPharmacyName(): ?string
    {
        return $this->pharmacy_name;
    }

    public function setPharmacyName(string $pharmacy_name): self
    {
        $this->pharmacy_name = $pharmacy_name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getPharmacistUser(): ?User
    {
        return $this->pharmacistUser;
    }

    public function setPharmacistUser(?User $pharmacistUser): self
    {
        $this->pharmacistUser = $pharmacistUser;

        // set (or unset) the owning side of the relation if necessary
        $newInfoPharmacist = null === $pharmacistUser ? null : $this;
        if ($pharmacistUser->getInfoPharmacist() !== $newInfoPharmacist) {
            $pharmacistUser->setInfoPharmacist($newInfoPharmacist);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->pharmacy_name;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * @param mixed $fichier
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
    }

}
