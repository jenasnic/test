<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Container;
use Faker\Generator;

class ContainerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $item = $this->buildData($faker);
            $manager->persist($item);

            if (0 === $i % 10) {
                $manager->flush();
            }
        }

        $manager->flush();
    }

    protected function buildData(Generator $faker)
    {
        $container = new Container();

        $container->setLabel($faker->word);
        $container->setWidth($faker->numberBetween(100, 200));
        $container->setHeight($faker->numberBetween(50, 100));

        return $container;
    }
}
