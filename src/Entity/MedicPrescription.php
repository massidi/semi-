<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicPrescriptionRepository")
 */
class MedicPrescription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateOfBirth;

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
    private $unite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dosage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $examination;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $health_regine;


    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

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

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getDosage(): ?string
    {
        return $this->dosage;
    }

    public function setDosage(string $dosage): self
    {
        $this->dosage = $dosage;

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

    public function getDocName(): ?doctor
    {
        return $this->docName;
    }

    public function setDocName(?doctor $docName): self
    {
        $this->docName = $docName;

        return $this;
    }
}
