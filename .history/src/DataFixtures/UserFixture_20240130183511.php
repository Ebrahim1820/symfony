<?php

namespace App\DataFixtures;


use Doctrine\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'main_users')

        $manager->flush();
    }
}
