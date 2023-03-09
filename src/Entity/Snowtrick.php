<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SnowtrickRepository;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SnowtrickRepository::class)]
#[UniqueEntity('title', message : 'Le titre de la figure existe déjà en base de données.', groups: ['new', 'edit'])]
#[UniqueEntity('slug')]
class Snowtrick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique:true)]
    #[Assert\NotBlank(message: 'Le titre doit être renseigné.', groups: ['new', 'edit'])]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le titre doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le titre ne peut excéder {{ limit }} caractères.'
    )]
    private ?string $title = null;

    #[ORM\Column(length: 50)]
    private ?string $author = null;

    #[ORM\Column(length: 50, unique:true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Le contenu ne peut être vide.', groups: ['new', 'edit'])]
    private ?string $content = null;

    
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $creationDate;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $modificationDate = null;

    #[ORM\ManyToOne(inversedBy: 'snowtricks', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'snowtricks', targetEntity: TrickGroup::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Vous devez assigner un groupe à la figure.', groups: ['new', 'edit'])]
    private ?TrickGroup $trickGroup = null;

    #[ORM\OneToMany(mappedBy: 'snowtrick', targetEntity: ChatMessage::class, orphanRemoval: true)]
    #[Assert\Valid()]
    private Collection $chatMessages;

    #[ORM\OneToMany(mappedBy: 'snowtrick', targetEntity: Video::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Assert\Valid()]
    private Collection $videos;

    #[ORM\OneToMany(mappedBy: 'snowtrick', targetEntity: Picture::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Assert\Valid()]
    private Collection $pictures;

    public function __construct()
    {
        $this->chatMessages = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->creationDate = new \DateTimeImmutable();
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getCreationDate(): ?\DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeImmutable $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getModificationDate(): ?\DateTimeImmutable
    {
        return $this->modificationDate;
    }

    public function setModificationDate(?\DateTimeImmutable $modificationDate): self
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTrickGroup(): ?TrickGroup
    {
        return $this->trickGroup;
    }

    public function setTrickGroup(?TrickGroup $trickGroup): self
    {
        $this->trickGroup = $trickGroup;

        return $this;
    }

    /**
     * @return Collection<int, ChatMessage>
     */
    public function getChatMessages(): Collection
    {
        return $this->chatMessages;
    }

    public function addChatMessage(ChatMessage $chatMessage): self
    {
        if (!$this->chatMessages->contains($chatMessage)) {
            $this->chatMessages->add($chatMessage);
            $chatMessage->setSnowtrick($this);
        }

        return $this;
    }

    public function removeChatMessage(ChatMessage $chatMessage): self
    {
        if ($this->chatMessages->removeElement($chatMessage)) {
            // set the owning side to null (unless already changed)
            if ($chatMessage->getSnowtrick() === $this) {
                $chatMessage->setSnowtrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setSnowtrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getSnowtrick() === $this) {
                $video->setSnowtrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setSnowtrick($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getSnowtrick() === $this) {
                $picture->setSnowtrick(null);
            }
        }

        return $this;
    }
}
