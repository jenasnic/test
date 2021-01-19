<?php

namespace App\Entity;

use App\Entity\ValueObject\CarInfo;
use App\Entity\ValueObject\PassportInfo;
use App\Enum\UserTypeEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\UserRepository::class)
 */
class User
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
    private ?string $firstname = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $lastname = null;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private ?string $username = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $type = null;

    /**
     * @ORM\Embedded(class="App\Entity\ValueObject\CarInfo")
     */
    private ?CarInfo $carInfo = null;

    /**
     * @ORM\Embedded(class="App\Entity\ValueObject\PassportInfo")
     */
    private ?PassportInfo $passportInfo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getCarInfo(): ?CarInfo
    {
        return $this->carInfo;
    }

    public function setCarInfo(?CarInfo $carInfo): void
    {
        $this->carInfo = $carInfo;
    }

    public function getPassportInfo(): ?PassportInfo
    {
        return $this->passportInfo;
    }

    public function setPassportInfo(?PassportInfo $passportInfo): void
    {
        $this->passportInfo = $passportInfo;
    }

    public function getInfos(): string
    {
        if (UserTypeEnum::CAR === $this->type) {
            return sprintf(
                'car [%s] - %uCV',
                $this->getCarInfo()->getLicensePlate(),
                $this->getCarInfo()->getHorsePower()
            );
        }
        if (UserTypeEnum::PASSPORT === $this->type) {
            return sprintf(
                'passport [%s] - %s (exp le %s)',
                $this->getPassportInfo()->getNumber(),
                $this->getPassportInfo()->getCountry(),
                $this->getPassportInfo()->getExpireAt()->format('d/M/Y')
            );
        }
    }
}
