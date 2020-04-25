<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatientRepository")
 */
class Patient
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="integer")
     */
    private $weigth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mobile;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="infoPatient", cascade={"persist", "remove"})
     */
    private $patientUser;


    public function __construct()
    {
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getWeigth(): ?int
    {
        return $this->weigth;
    }

    public function setWeigth(int $weigth): self
    {
        $this->weigth = $weigth;

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

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatientUser(): ?User
    {
        return $this->patientUser;
    }

    public function setPatientUser(?User $patientUser): self
    {
        $this->patientUser = $patientUser;

        // set (or unset) the owning side of the relation if necessary
        $newInfoPatient = null === $patientUser ? null : $this;
        if ($patientUser->getInfoPatient() !== $newInfoPatient) {
            $patientUser->setInfoPatient($newInfoPatient);
        }

        return $this;
    }



}
