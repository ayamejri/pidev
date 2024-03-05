<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Evenement;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    
    #[Assert\NotBlank(message: "vous devez mettre le Description!!!")]
    private $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateParticipation = null;

    #[ORM\ManyToOne(inversedBy: 'Participant')]
    private ?Evenement $Evenement = null;


    
    public function __construct()
    {
        $this->dateParticipation = new \DateTime('now');
    }
    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
    public function getDateParticipation(): ?\DateTimeInterface
    {
        return $this->dateParticipation;
    }

    public function setDateParticipation(\DateTimeInterface $dateParticipation): static
    {
        $this->dateParticipation = $dateParticipation;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->Evenement;
    }

    public function setEvenement(?Evenement $Evenement): static
    {
        $this->Evenement = $Evenement;

        return $this;
    }


   
}
