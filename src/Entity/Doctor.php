<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctorRepository")
 *  @Vich\Uploadable()
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
     * @ORM\Column( type="string", length=255, )
     * @var string
     */
    private $image;


    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="infoDoctor", cascade={"persist", "remove"})
     */
    private $doctorUser;


    public function __construct()
    {
        $this->updatedAt = new \DateTime();

    }




    public function getId(): ?int
    {
        return $this->id;
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
     * @param File|null $imageFile
     * @throws \Exception
     */
    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return $this
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdateAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }




    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDoctorUser(): ?User
    {
        return $this->doctorUser;
    }

    public function setDoctorUser(?User $doctorUser): self
    {
        $this->doctorUser = $doctorUser;

        // set (or unset) the owning side of the relation if necessary
        $newInfoDoctor = null === $doctorUser ? null : $this;
        if ($doctorUser->getInfoDoctor() !== $newInfoDoctor) {
            $doctorUser->setInfoDoctor($newInfoDoctor);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->hospital_name;
    }


//    /**
//     * @inheritDoc
//     */
//    public function serialize()
//    {
//
//        return serialize([
//            $this->id,
//            $this->image,
//
//
//
//        ]);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function unserialize($serialized)
//    {
//
//        list(
//
//            $this->id,
//            $this->image
//            ) =unserialize($serialized, ['Allowed_classes' =>false]);
//    }
}
