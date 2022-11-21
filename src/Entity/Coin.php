<?php

namespace App\Entity;

use App\Repository\CoinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CoinRepository::class)]
#[ORM\Table(name:"coins")]
class Coin
{
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

    #[ORM\Column(nullable:true)]
    #[Groups(['list'])]
    private ?float $price = null;

    #[ORM\Column(nullable:true)]
    #[Groups(['list'])]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['list'])]
    private ?\DateTimeInterface $priceUpdated = null;

    #[ORM\OneToMany(mappedBy: 'coinId', targetEntity: CoinArchive::class, orphanRemoval: true)]
    private Collection $archivedPrice;

    public function __construct()
    {
        $this->archivedPrice = new ArrayCollection();
    }

    

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

    public function getPrice (): ?float {
        return $this->price;
    }

    public function setPrice (?float $price): self {
        $this->price = $price;
        return $this;
    }

    public function getImage (): ?string {
        return $this->image;
    }

    public function setImage (?string $imagePath): self {
        $this->image = $imagePath;
        return $this;
    }

    public function getPriceUpdated (): ?\DateTimeInterface {
        return $this->priceUpdated;
    }

    public function setPriceUpdated (?\DateTimeInterface $priceUpdated): self {
        $this->priceUpdated = $priceUpdated;
        return $this;
    }

    /**
     * @return Collection<int, CoinArchive>
     */
    public function getArchivedPrice(): Collection
    {
        return $this->archivedPrice;
    }

    public function addArchivedPrice(CoinArchive $archivedPrice): self
    {
        if (!$this->archivedPrice->contains($archivedPrice)) {
            $this->archivedPrice->add($archivedPrice);
            $archivedPrice->setCoinId($this);
        }

        return $this;
    }

    public function removeArchivedPrice(CoinArchive $archivedPrice): self
    {
        if ($this->archivedPrice->removeElement($archivedPrice)) {
            // set the owning side to null (unless already changed)
            if ($archivedPrice->getCoinId() === $this) {
                $archivedPrice->setCoinId(null);
            }
        }

        return $this;
    }
}
