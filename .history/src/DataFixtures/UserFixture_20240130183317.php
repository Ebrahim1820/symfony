<?php

namespace App\DataFixtures;


use Doctrine\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
