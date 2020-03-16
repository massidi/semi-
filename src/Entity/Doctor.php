<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctorRepository")
 */
class Doctor
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
     * * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Your lastname cannot contain a number")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *   message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hospital_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialization;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MedicPrescription", mappedBy="doctor")
     */
    private $prescriptions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Patient", inversedBy="doctors")
     */
    private $patient;

    public function __construct()
    {
        $this->prescriptions = new ArrayCollection();
        $this->patient = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

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

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getHospitalName(): ?string
    {
        return $this->hospital_name;
    }

    public function setHospitalName(string $hospital_name): self
    {
        $this->hospital_name = $hospital_name;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(string $specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    /**
     * @return Collection|MedicPrescription[]
     */
    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }

    public function addPrescription(MedicPrescription $prescription): self
    {
        if (!$this->prescriptions->contains($prescription)) {
            $this->prescriptions[] = $prescription;
            $prescription->setDoctor($this);
        }

        return $this;
    }

    public function removePrescription(MedicPrescription $prescription): self
    {
        if ($this->prescriptions->contains($prescription)) {
            $this->prescriptions->removeElement($prescription);
            // set the owning side to null (unless already changed)
            if ($prescription->getDoctor() === $this) {
                $prescription->setDoctor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Patient[]
     */
    public function getPatient(): Collection
    {
        return $this->patient;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patient->contains($patient)) {
            $this->patient[] = $patient;
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patient->contains($patient)) {
            $this->patient->removeElement($patient);
        }

        return $this;
    }


}
