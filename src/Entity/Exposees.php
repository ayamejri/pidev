<?php

namespace App\Entity;

use App\Repository\ExposeesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;

#[ORM\Entity(repositoryClass: ExposeesRepository::class)]
class Exposees
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez Remplir Ce Champs*")]
    private ?string $nom_e = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;
    

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez Remplir Ce Champs*")]
    private ?string $produits_existants = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez Remplir Ce Champs*")]
    private $imageExposees = null;
    
    #[ORM\OneToMany(mappedBy: 'exposee', targetEntity: Produits::class)]
    private Collection $Produits;
    public function __construct()
    {
        $this->Produits = new ArrayCollection();
        $this->date_debut = new \DateTime('now');
        $this->date_fin = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomE(): ?string
    {
        return $this->nom_e;
    }

    public function setNomE(string $nom_e): static
    {
        $this->nom_e = $nom_e;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
{
    return $this->date_debut;
}

public function setDateDebut(\DateTimeInterface $date_debut): static
{
    $this->date_debut = $date_debut;

    return $this;
}

public function getDateFin(): ?\DateTimeInterface
{
    return $this->date_fin;
}

public function setDateFin(\DateTimeInterface $date_fin): static
{
    $this->date_fin = $date_fin;

    return $this;
}


    public function getProduitsExistants(): ?string
    {
        return $this->produits_existants;
    }

    //public function setProduitsExistants(string $produits_existants): static
   // {
    //    $this->produits_existants = $produits_existants;

    //    return $this;
   // }
    public function getImageExposees()
    {
        return $this->imageExposees;
    }

    public function setImageExposees($imageExposees)
    {
        $this->imageExposees = $imageExposees;

        return $this;
    }
    public function validateDate(ExecutionContextInterface $context, $payload)
    {
        if ($this->date_debut < new \DateTime('now')) {
            $context->buildViolation('La date de début ne peut pas être antérieure à aujourd\'hui.')
                ->atPath('date_debut')
                ->addViolation();
        }

        if ($this->date_fin < new \DateTime('now')) {
            $context->buildViolation('La date de fin ne peut pas être antérieure à aujourd\'hui.')
                ->atPath('date_fin')
                ->addViolation();
        }
    }

    public function setProduitsExistants(string $produits_existants): static
    {
        $entityManager = $this->getDoctrine()->getManager();
        $produitRepository = $entityManager->getRepository(Produits::class);
        $produit = $produitRepository->find($produits_existants);
        if (!$produit) {
            throw new \RuntimeException('Produit Inexistant');
        }
        $this->Produits->add($produit);

        $this->produits_existants = $produits_existants;

        return $this;
    }
}