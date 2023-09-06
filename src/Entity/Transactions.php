<?php

namespace App\Entity;

use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionsRepository::class)]
class Transactions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $type_transaction = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne]
    private ?CryptoMonnaie $crypto = null;

    #[ORM\ManyToOne]
    private ?User $expediteur = null;

    #[ORM\ManyToOne]
    private ?User $recepteur = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTransaction(): ?string
    {
        return $this->type_transaction;
    }

    public function setTypeTransaction(string $type_transaction): static
    {
        $this->type_transaction = $type_transaction;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

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

    public function getCrypto(): ?CryptoMonnaie
    {
        return $this->crypto;
    }

    public function setCrypto(?CryptoMonnaie $crypto): static
    {
        $this->crypto = $crypto;

        return $this;
    }

    public function getExpediteur(): ?User
    {
        return $this->expediteur;
    }

    public function setExpediteur(?User $expediteur): static
    {

            $this->expediteur = $expediteur;
        

        return $this;
    }

    public function getRecepteur(): ?User
    {
        return $this->recepteur;
    }

    public function setRecepteur(?User $recepteur): static
    {
            $this->recepteur = $recepteur;

        return $this;
    }
}
