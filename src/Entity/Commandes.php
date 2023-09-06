<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?CryptoMonnaie $je_donne = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?CryptoMonnaie $je_recois = null;

    #[ORM\Column]
    private ?float $montantEnvoye = null;

    #[ORM\Column]
    private ?float $montantRecevoir = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseReception = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseEnvoyeur = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJeDonne(): ?CryptoMonnaie
    {
        return $this->je_donne;
    }

    public function setJeDonne(?CryptoMonnaie $je_donne): static
    {
        $this->je_donne = $je_donne;

        return $this;
    }

    public function getJeRecois(): ?CryptoMonnaie
    {
        return $this->je_recois;
    }

    public function setJeRecois(?CryptoMonnaie $je_recois): static
    {
        $this->je_recois = $je_recois;

        return $this;
    }

    public function getMontantEnvoye(): ?float
    {
        return $this->montantEnvoye;
    }

    public function setMontantEnvoye(float $montantEnvoye): static
    {
        $this->montantEnvoye = $montantEnvoye;

        return $this;
    }

    public function getMontantRecevoir(): ?float
    {
        return $this->montantRecevoir;
    }

    public function setMontantRecevoir(float $montantRecevoir): static
    {
        $this->montantRecevoir = $montantRecevoir;

        return $this;
    }

    public function getAdresseReception(): ?string
    {
        return $this->adresseReception;
    }

    public function setAdresseReception(string $adresseReception): static
    {
        $this->adresseReception = $adresseReception;

        return $this;
    }

    public function getAdresseEnvoyeur(): ?string
    {
        return $this->adresseEnvoyeur;
    }

    public function setAdresseEnvoyeur(string $adresseEnvoyeur): static
    {
        $this->adresseEnvoyeur = $adresseEnvoyeur;

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
}
