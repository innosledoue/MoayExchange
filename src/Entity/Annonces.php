<?php

namespace App\Entity;

use App\Repository\AnnoncesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnoncesRepository::class)]
class Annonces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montant_dispo = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 10)]
    private ?string $type_annonce = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

    #[ORM\ManyToOne]
    private ?CryptoMonnaie $crypto = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantDispo(): ?float
    {
        return $this->montant_dispo;
    }

    public function setMontantDispo(float $montant_dispo): static
    {
        $this->montant_dispo = $montant_dispo;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTypeAnnonce(): ?string
    {
        return $this->type_annonce;
    }

    public function setTypeAnnonce(string $type_annonce): static
    {
        $this->type_annonce = $type_annonce;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCrypto(): ?CryptoMonnaie
    {
        return $this->crypto;
    }

    public function setCrypto(?CryptoMonnaie $crypto): static
    {
        $this->crypto = $crypto;

        return $this;
    }
}
