<?php

namespace App\Entity;

use Closure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email( message = "The email '{{ value }}' is not a valid email.")
     *
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $last_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MedicPrescription", mappedBy="medicName")
     */
    private $prescription;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MedicPrescription", mappedBy="patientName")
     */
    private $patient_prescription;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Doctor", inversedBy="doctorUser", cascade={"persist", "remove"})
     */
    private $infoDoctor;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pharmacist", inversedBy="pharmacistUser", cascade={"persist", "remove"})
     */
    private $infoPharmacist;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Patient", inversedBy="patientUser", cascade={"persist", "remove"})
     */
    private $infoPatient;


    public function __construct()
    {
        $this->prescription = new ArrayCollection();
        $this->patient_prescription = new ArrayCollection();
    }





    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every doctorProfile at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        global $kernel;
        if (method_exists($kernel, 'getKernel'))
            $kernel = $kernel->getKernel();

        $this->password = $kernel->getContainer()->get('security.password_encoder')->encodePassword($this, $password);
        return $this;

    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the doctorProfile, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return User
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return User
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }
//    /**
//     * @return mixed
//     */
//    public function getUsername()
//    {
//        return $this->username;
//    }

    /**
     * A visual identifier that represents this doctorProfile.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }



    /**
     * @return Collection|MedicPrescription[]
     */
    public function getPrescription(): Collection
    {
        return $this->prescription;
    }

    public function addPrescription(MedicPrescription $prescription): self
    {
        if (!$this->prescription->contains($prescription)) {
            $this->prescription[] = $prescription;
            $prescription->setMedicName($this);
        }

        return $this;
    }

    public function removePrescription(MedicPrescription $prescription): self
    {
        if ($this->prescription->contains($prescription)) {
            $this->prescription->removeElement($prescription);
            // set the owning side to null (unless already changed)
            if ($prescription->getMedicName() === $this) {
                $prescription->setMedicName(null);
            }
        }

        return $this;
    }



    /**
     * @inheritDoc
     */
    public function add($element)
    {
        // TODO: Implement add() method.
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        // TODO: Implement clear() method.
    }

    /**
     * @inheritDoc
     */
    public function contains($element)
    {
        // TODO: Implement contains() method.
    }

    /**
     * @inheritDoc
     */
    public function isEmpty()
    {
        // TODO: Implement isEmpty() method.
    }

    /**
     * @inheritDoc
     */
    public function remove($key)
    {
        // TODO: Implement remove() method.
    }

    /**
     * @inheritDoc
     */
    public function removeElement($element)
    {
        // TODO: Implement removeElement() method.
    }

    /**
     * @inheritDoc
     */
    public function containsKey($key)
    {
        // TODO: Implement containsKey() method.
    }

    /**
     * @inheritDoc
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function getKeys()
    {
        // TODO: Implement getKeys() method.
    }

    /**
     * @inheritDoc
     */
    public function getValues()
    {
        // TODO: Implement getValues() method.
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value)
    {
        // TODO: Implement set() method.
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        // TODO: Implement toArray() method.
    }

    /**
     * @inheritDoc
     */
    public function first()
    {
        // TODO: Implement first() method.
    }

    /**
     * @inheritDoc
     */
    public function last()
    {
        // TODO: Implement last() method.
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * @inheritDoc
     */
    public function exists(Closure $p)
    {
        // TODO: Implement exists() method.
    }

    /**
     * @inheritDoc
     */
    public function filter(Closure $p)
    {
        // TODO: Implement filter() method.
    }

    /**
     * @inheritDoc
     */
    public function forAll(Closure $p)
    {
        // TODO: Implement forAll() method.
    }

    /**
     * @inheritDoc
     */
    public function map(Closure $func)
    {
        // TODO: Implement map() method.
    }

    /**
     * @inheritDoc
     */
    public function partition(Closure $p)
    {
        // TODO: Implement partition() method.
    }

    /**
     * @inheritDoc
     */
    public function indexOf($element)
    {
        // TODO: Implement indexOf() method.
    }

    /**
     * @inheritDoc
     */
    public function slice($offset, $length = null)
    {
        // TODO: Implement slice() method.
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        // TODO: Implement count() method.
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        // TODO: Implement valid() method.
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    /**
     * @return Collection|MedicPrescription[]
     */
    public function getPatientPrescription(): Collection
    {
        return $this->patient_prescription;
    }

    public function addPatientPrescription(MedicPrescription $patientPrescription): self
    {
        if (!$this->patient_prescription->contains($patientPrescription)) {
            $this->patient_prescription[] = $patientPrescription;
            $patientPrescription->setPatientName($this);
        }

        return $this;
    }

    public function removePatientPrescription(MedicPrescription $patientPrescription): self
    {
        if ($this->patient_prescription->contains($patientPrescription)) {
            $this->patient_prescription->removeElement($patientPrescription);
            // set the owning side to null (unless already changed)
            if ($patientPrescription->getPatientName() === $this) {
                $patientPrescription->setPatientName(null);
            }
        }

        return $this;
    }

    public function getInfoDoctor(): ?Doctor
    {
        return $this->infoDoctor;
    }

    public function setInfoDoctor(?Doctor $infoDoctor): self
    {
        $this->infoDoctor = $infoDoctor;

        return $this;
    }

    public function getInfoPharmacist(): ?Pharmacist
    {
        return $this->infoPharmacist;
    }

    public function setInfoPharmacist(?Pharmacist $infoPharmacist): self
    {
        $this->infoPharmacist = $infoPharmacist;

        return $this;
    }

    /**
     * @return mixed
     */
    public function __toString():string
    {
        return $this->username;
    }

    public function getInfoPatient(): ?Patient
    {
        return $this->infoPatient;
    }

    public function setInfoPatient(?Patient $infoPatient): self
    {
        $this->infoPatient = $infoPatient;

        return $this;
    }



}
