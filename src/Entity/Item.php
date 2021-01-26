<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\ItemRepository::class)
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $label = null;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $price = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $availableAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $expireAt;

    /**
     * @ORM\ManyToOne(targetEntity="Container", inversedBy="items")
     */
    private ?Container $container = null;

    /**
     * @ORM\ManyToOne(targetEntity="Brand")
     */
    private ?Brand $brand = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getAvailableAt(): ?DateTime
    {
        return $this->availableAt;
    }

    public function setAvailableAt(DateTime $availableAt): void
    {
        $this->availableAt = $availableAt;
    }

    public function getExpireAt(): ?DateTime
    {
        return $this->expireAt;
    }

    public function setExpireAt(DateTime $expireAt): void
    {
        $this->expireAt = $expireAt;
    }

    public function getContainer(): ?Container
    {
        return $this->container;
    }

    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): void
    {
        $this->brand = $brand;
    }
}
