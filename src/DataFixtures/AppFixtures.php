<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Liior\Faker\Prices;
use Bezhanov\Faker\Provider\Commerce;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new Prices($faker));

        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setTitle("laptop2")
                ->setPrice($faker->price(20, 200))
                ->setImage($faker->imageUrl(20,200));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
