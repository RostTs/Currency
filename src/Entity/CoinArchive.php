<?php

namespace App\Entity;

use App\Repository\CoinArchiveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CoinArchiveRepository::class)]
class CoinArchive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'archivedPrice')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Coin $coinId = null;

    #[ORM\Column]
    #[Groups(['coin'])]
    private ?float $price = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['coin'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoinId(): ?Coin
    {
        return $this->coinId;
    }

    public function setCoinId(?Coin $coinId): self
    {
        $this->coinId = $coinId;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
