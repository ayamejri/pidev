<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "vous devez mettre l'image!!!")]
    private $ImageEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "vous devez mettre le theme!!!")]

    private ?string $themeEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "vous devez mettre le type d'evenement!!!")]
    private ?string $typeEvenement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "vous devez mettre le Nombre de Participant!!!")]
    private ?int $nbrParticipant = null;

    #[ORM\ManyToOne(inversedBy: 'Evenement')]
    private ?Publicite $Publicite = null;

    #[ORM\OneToMany(mappedBy: 'Evenement', targetEntity: Participant::class)]
    private Collection $Participant;

    public function __construct()
    {
        $this->Participant = new ArrayCollection();
        $this->dateDebut = new \DateTime('now');
        $this->dateFin = new \DateTime('now');
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageEvenement()
    {
        return $this->ImageEvenement;
    }

    public function setImageEvenement($ImageEvenement): static
    {
        $this->ImageEvenement = $ImageEvenement;

        return $this;
    }

    public function getThemeEvenement(): ?string
    {
        return $this->themeEvenement;
    }

    public function setThemeEvenement(string $themeEvenement): static
    {
        $this->themeEvenement = $themeEvenement;

        return $this;
    }

    public function getTypeEvenement(): ?string
    {
        return $this->typeEvenement;
    }

    public function setTypeEvenement(string $typeEvenement): static
    {
        $this->typeEvenement = $typeEvenement;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNbrParticipant(): ?int
    {
        return $this->nbrParticipant;
    }

    public function setNbrParticipant(int $nbrParticipant): static
    {
        $this->nbrParticipant = $nbrParticipant;

        return $this;
    }

    public function getPublicite(): ?Publicite
    {
        return $this->Publicite;
    }

    public function setPublicite(?Publicite $Publicite): static
    {
        $this->Publicite = $Publicite;

        return $this;
    }

    public function __toString ()
    {
        return $this->themeEvenement;
    }
    
    /**
     * @return Collection<int, Participant>
     */
    public function getParticipant(): Collection
    {
        return $this->Participant;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->Participant->contains($participant)) {
            $this->Participant->add($participant);
            $participant->setParticipant($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        if ($this->Participant->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getParticipant() === $this) {
                $participant->setParticipant(null);
            }
        }

        return $this;
    }
   
}
