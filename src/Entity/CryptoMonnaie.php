<?php

namespace App\Entity;

use App\Repository\CryptoMonnaieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CryptoMonnaieRepository::class)]
class CryptoMonnaie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $crypto_name = null;

    #[ORM\Column(length: 5)]
    private ?string $symbole = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCryptoName(): ?string
    {
        return $this->crypto_name;
    }

    public function setCryptoName(string $crypto_name): static
    {
        $this->crypto_name = $crypto_name;

        return $this;
    }

    public function getSymbole(): ?string
    {
        return $this->symbole;
    }

    public function setSymbole(string $symbole): static
    {
        $this->symbole = $symbole;

        return $this;
    }
}
