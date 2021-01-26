<?php

namespace App\DataFixtures;

use App\Entity\Container;
use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Brand;

class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    public const COUNT_PER_CONTAINER = 3;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $brandCodes = ['AAA', 'BBB', 'CCC'];

        for ($i = 0; $i < ContainerFixtures::COUNT; $i++) {
            for ($j = 0; $j < self::COUNT_PER_CONTAINER; $j++) {
                $container = $this->getReference(sprintf('container_%u', $i));
                $brand = $this->getReference(sprintf('brand_%s', $brandCodes[$faker->numberBetween(0,2)]));

                $item = $this->buildData($faker, $container, $brand);
                $manager->persist($item);

                $this->addReference(sprintf('container_%u_item_%u', $i, $j), $item);
            }

            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            BrandFixtures::class,
            ContainerFixtures::class,
        ];
    }

    protected function buildData(Generator $faker, Container $container, Brand $brand)
    {
        $item = new Item();

        $item->setLabel($faker->word);
        $item->setPrice($faker->numberBetween(1, 10));
        $item->setAvailableAt($faker->dateTimeBetween('-30days', '-1day'));
        $item->setExpireAt($faker->dateTimeBetween('+1day', '+30days'));
        $item->setContainer($container);
        $item->setBrand($brand);

        return $item;
    }
}
