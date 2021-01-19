<?php

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class CarInfo
{
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private ?string $licensePlate;

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private ?int $horsePower;

    public function __construct(?string $licensePlate, ?int $horsePower)
    {
        $this->licensePlate = $licensePlate;
        $this->horsePower = $horsePower;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(?string $licensePlate)
    {
        $this->licensePlate = $licensePlate;
    }

    public function getHorsePower(): ?int
    {
        return $this->horsePower;
    }

    public function setHorsePower(?int $horsePower)
    {
        $this->horsePower = $horsePower;
    }
}
