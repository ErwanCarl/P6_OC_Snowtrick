<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PictureRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[UniqueEntity('fileName', message : 'Ce nom de fichier existe déjà.')]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $fileName = null;

    private $file = null;

    #[ORM\ManyToOne(inversedBy: 'pictures', targetEntity: Snowtrick::class)]
    #[ORM\JoinColumn(nullable: false)]
    // #[ORM\JoinColumn(onDelete="CASCADE")]
    private ?Snowtrick $snowtrick = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFile() : UploadedFile
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getSnowtrick(): ?Snowtrick
    {
        return $this->snowtrick;
    }

    public function setSnowtrick(?Snowtrick $snowtrick): self
    {
        $this->snowtrick = $snowtrick;

        return $this;
    }
}
