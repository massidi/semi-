<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicPrescriptionRepository")
 */
class MedicPrescription extends \App\Repository\MedicPrescriptionRepository
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $diagnostic;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $blood_pressure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pulse_rate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $drug;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $examination;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $health_regine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="prescription")
     */
    private $medicName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="patient_prescription")
     */
    private $patientName;



    public function __construct()
    {

        $this->createdAt= new \DateTime();

    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt= new \DateTime('now');


        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDiagnostic(): ?string
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(string $diagnostic): self
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    public function getBloodPressure(): ?string
    {
        return $this->blood_pressure;
    }

    public function setBloodPressure(string $blood_pressure): self
    {
        $this->blood_pressure = $blood_pressure;

        return $this;
    }

    public function getPulseRate(): ?string
    {
        return $this->pulse_rate;
    }

    public function setPulseRate(string $pulse_rate): self
    {
        $this->pulse_rate = $pulse_rate;

        return $this;
    }

    public function getDrug(): ?string
    {
        return $this->drug;
    }

    public function setDrug(string $drug): self
    {
        $this->drug = $drug;

        return $this;
    }

    public function getExamination(): ?string
    {
        return $this->examination;
    }

    public function setExamination(string $examination): self
    {
        $this->examination = $examination;

        return $this;
    }

    public function getHealthRegine(): ?string
    {
        return $this->health_regine;
    }

    public function setHealthRegine(string $health_regine): self
    {
        $this->health_regine = $health_regine;

        return $this;
    }


    public function getMedicName(): ?User
    {
        return $this->medicName;
    }

    public function setMedicName(?User $medicName): self
    {
        $this->medicName = $medicName;

        return $this;
    }



    public function getPatientName(): ?User
    {
        return $this->patientName;
    }

    public function setPatientName(?User $patientName): self
    {
        $this->patientName = $patientName;

        return $this;
    }
    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->age;
    }




}
