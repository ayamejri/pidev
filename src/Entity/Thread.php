<?php

namespace App\Entity;

use App\Repository\ThreadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreadRepository::class)]
class Thread
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $topic = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdat = null;

    #[ORM\OneToMany(mappedBy: 'thread', targetEntity: Post::class)]
    private Collection $relation;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): static
    {
        $this->topic = $topic;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): static
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * @return Collection<int, post>
     */
    
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(post $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setThread($this);
        }

        return $this;
    }

    public function removeRelation(post $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getThread() === $this) {
                $relation->setThread(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }
}
