<?php

namespace App\Entity;

use App\Repository\CoinRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CoinRepository::class)]
#[ORM\Table(name:"coins")]
class Coin
{
    //TODO: Concert annotations
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $coingeckoId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $symbol = null;

    #[ORM\Column(length: 255)]
    #[Groups(['list'])]
    private ?string $name = null;

    #[ORM\Column()]
    #[Groups(['list'])]
    private bool $isFavorite = false;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['list'])]
    private ?\DateTimeInterface $created = null;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoingeckoId(): ?string
    {
        return $this->coingeckoId;
    }

    public function setCoingeckoId(string $coingeckoId): self
    {
        $this->coingeckoId = $coingeckoId;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getIsFavorite(): bool
    {
        return $this->isFavorite;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }
}
