<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="disc")
 */
class Disc implements \JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", nullable=false, length=36)
     */
    protected $id;

    /**
     * @var double
     *
     * @ORM\Column(type="float", nullable=true, options={"default": 0})
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $priceStatus;

    /**
     * @var Type
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Type")
     * @ORM\JoinColumn(nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @var Manufacturer
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Manufacturer")
     * @ORM\JoinColumn(nullable=true)
     */
    private $manufacturer;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $material;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $speed;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $glide;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $stability;

    /**
     * @var double
     *
     * @ORM\Column(type="float", nullable=false)
     */
    private $fade;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $additional;

    /**
     * @var double
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default": false})
     */
    private $isMissing;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $missingDescription;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default": false})
     */
    private $isSold;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $soldAt;

    /**
     * @var double
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $soldFor;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default": false})
     */
    private $isBroken;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default": false})
     */
    private $isHoleInOne;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $holeInOneDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $holeInOneDescription;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default": false})
     */
    private $isCollectionItem;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default": false})
     */
    private $isOwnStamp;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default": false})
     */
    private $isDonated;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $donationDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct(string $id)
    {
        $this->id = $id;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price = null): void
    {
        $this->price = $price;
    }

    public function getPriceStatus(): ?string
    {
        return $this->priceStatus;
    }

    public function setPriceStatus(string $priceStatus = null): void
    {
        $this->priceStatus = $priceStatus;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param Type $type
     */
    public function setType(Type $type): void
    {
        $this->type = $type;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Manufacturer
     */
    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }

    /**
     * @param Manufacturer $manufacturer
     */
    public function setManufacturer(Manufacturer $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(string $material = null): void
    {
        $this->material = $material;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): void
    {
        $this->speed = $speed;
    }

    public function getGlide(): int
    {
        return $this->glide;
    }

    public function setGlide(int $glide): void
    {
        $this->glide = $glide;
    }

    public function getStability(): int
    {
        return $this->stability;
    }

    public function setStability(int $stability): void
    {
        $this->stability = $stability;
    }

    public function getFade(): float
    {
        return $this->fade;
    }

    public function setFade(float $fade): void
    {
        $this->fade = $fade;
    }

    public function getAdditional(): string
    {
        return $this->additional;
    }

    public function setAdditional(string $additional): void
    {
        $this->additional = $additional;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function isMissing(): bool
    {
        return $this->isMissing;
    }

    public function setIsMissing(bool $isMissing): void
    {
        $this->isMissing = $isMissing;
    }

    public function getMissingDescription(): ?string
    {
        return $this->missingDescription;
    }

    public function setMissingDescription(string $missingDescription = null): void
    {
        $this->missingDescription = $missingDescription;
    }

    public function isSold(): string
    {
        return $this->isSold;
    }

    public function setIsSold(bool $isSold): void
    {
        $this->isSold = $isSold;
    }

    public function getSoldAt(): ?\DateTime
    {
        return $this->soldAt;
    }

    public function setSoldAt(\DateTime $soldAt = null): void
    {
        $this->soldAt = $soldAt;
    }

    public function getSoldFor(): ?float
    {
        return $this->soldFor;
    }

    public function setSoldFor(float $soldFor = null): void
    {
        $this->soldFor = $soldFor;
    }

    public function isBroken(): bool
    {
        return $this->isBroken;
    }

    public function setIsBroken(bool $isBroken): void
    {
        $this->isBroken = $isBroken;
    }

    public function isHoleInOne(): bool
    {
        return $this->isHoleInOne;
    }

    public function setIsHoleInOne(bool $isHoleInOne): void
    {
        $this->isHoleInOne = $isHoleInOne;
    }


    public function getHoleInOneDate(): ?\DateTime
    {
        return $this->holeInOneDate;
    }


    public function setHoleInOneDate(\DateTime $holeInOneDate = null): void
    {
        $this->holeInOneDate = $holeInOneDate;
    }


    public function getHoleInOneDescription(): ?string
    {
        return $this->holeInOneDescription;
    }

    public function setHoleInOneDescription(string $holeInOneDescription = null): void
    {
        $this->holeInOneDescription = $holeInOneDescription;
    }


    public function isCollectionItem(): bool
    {
        return $this->isCollectionItem;
    }

    public function setIsCollectionItem(bool $isCollectionItem): void
    {
        $this->isCollectionItem = $isCollectionItem;
    }

    public function isOwnStamp(): bool
    {
        return $this->isOwnStamp;
    }

    public function setIsOwnStamp(bool $isOwnStamp): void
    {
        $this->isOwnStamp = $isOwnStamp;
    }

    public function isDonated(): bool
    {
        return $this->isDonated;
    }

    public function setIsDonated(bool $isDonated): void
    {
        $this->isDonated = $isDonated;
    }

    public function getDonationDescription(): ?string
    {
        return $this->donationDescription;
    }

    public function setDonationDescription(string $donationDescription = null): void
    {
        $this->donationDescription = $donationDescription;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function jsonSerialize()
    {
        return $this->id;
    }
}
