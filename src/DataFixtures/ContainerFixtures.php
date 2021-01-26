<?php

namespace App\DataFixtures;

use App\Entity\Container;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ContainerFixtures extends Fixture
{
    public const COUNT = 5;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::COUNT; $i++) {
            $item = $this->buildData($faker);
            $manager->persist($item);

            $this->addReference(sprintf('container_%u', $i), $item);
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
