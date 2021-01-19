<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\ValueObject\CarInfo;
use App\Entity\ValueObject\PassportInfo;
use App\Enum\UserTypeEnum;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = $this->getData();

        foreach ($data as $item) {
            $manager->persist($item);
        }

        $manager->flush();
    }

    protected function getData(): array
    {
        $data = [];

        $data[] = $this->buildData('Ray', 'Ichido', 'ray', UserTypeEnum::CAR, '111');
        $data[] = $this->buildData('Ted', 'Rettsu', 'ted', UserTypeEnum::CAR, '112');
        $data[] = $this->buildData('Jim', 'Daima', 'jim', UserTypeEnum::CAR, '113');
        $data[] = $this->buildData('Jean', 'Shusse', 'Jean', UserTypeEnum::CAR, '114');
        $data[] = $this->buildData('Dan', 'Monohoshi', 'dan', UserTypeEnum::CAR, '115');
        $data[] = $this->buildData('Anne-Laure', 'Kawa', 'laura', UserTypeEnum::PASSPORT, 'c1');
        $data[] = $this->buildData('Juliette', 'Uru', 'julie', UserTypeEnum::PASSPORT, 'c2');

        return $data;
    }

    protected function buildData(
        string $firstname,
        string $lastname,
        string $username,
        int $type,
        string $info
    ): User {
        $user = new User();

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setUsername($username);
        $user->setType($type);

        if (UserTypeEnum::CAR === $type) {
            $user->setCarInfo(new CarInfo('JL-'.$info, 4));
        }
        if (UserTypeEnum::PASSPORT === $type) {
            $user->setPassportInfo(new PassportInfo('PP-'.$info, 'France', new DateTime()));
        }

        return $user;
    }
}
