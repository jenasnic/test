<?php

namespace App\Entity\ValueObject;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class PassportInfo
{
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private ?string $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $country;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $expireAt;

    public function __construct(?string $number, ?string $country, ?DateTime $expireAt)
    {
        $this->number = $number;
        $this->country = $country;
        $this->expireAt = $expireAt;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number)
    {
        $this->number = $number;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country)
    {
        $this->country = $country;
    }

    public function getExpireAt(): ?DateTime
    {
        return $this->expireAt;
    }

    public function setExpireAt(?DateTime $expireAt)
    {
        $this->expireAt = $expireAt;
    }
}
