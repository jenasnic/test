<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $brand) {
            $manager->persist($brand);
            $this->addReference(sprintf('brand_%s', $brand->getCode()), $brand);
        }

        $manager->flush();
    }

    protected function getData()
    {
        $data = [];

        $data[] = $this->buildData('Alpha', 'AAA');
        $data[] = $this->buildData('Bravo', 'BBB');
        $data[] = $this->buildData('Charlie', 'CCC');

        return $data;
    }

    protected function buildData(string $label, string $code)
    {
        $brand = new Brand();

        $brand->setLabel($label);
        $brand->setCode($code);

        return $brand;
    }
}
