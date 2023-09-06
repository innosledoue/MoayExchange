<?php

namespace App\Entity;

use App\Repository\TauxChangeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TauxChangeRepository::class)]
class TauxChange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $monnaie_fiduciaire = null;

    #[ORM\Column]
    private ?float $taux_change_now = null;

    #[ORM\ManyToOne]
    private ?CryptoMonnaie $crypto = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonnaieFiduciaire(): ?string
    {
        return $this->monnaie_fiduciaire;
    }

    public function setMonnaieFiduciaire(string $monnaie_fiduciaire): static
    {
        $this->monnaie_fiduciaire = $monnaie_fiduciaire;

        return $this;
    }

    public function getTauxChangeNow(): ?float
    {
        return $this->taux_change_now;
    }

    public function setTauxChangeNow(float $taux_change_now): static
    {
        $this->taux_change_now = $taux_change_now;

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
