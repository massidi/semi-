<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EboutUsRepository")
 * @Vich\Uploadable
 */
class AboutUs
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
    private $title;

    /**
     * @ORM\Column(name="image", type="string", length=255, )
     * @var string
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @Vich\UploadableField(mapping="about_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;
//    /**
//     * @var DateTime
//     */
//    private $updatedAt;

    public function __construct()
    {
        $this->updateAt = new DateTime();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updateAt = new DateTime('now');
        }
    }

    public function setImageFile(?string $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}
