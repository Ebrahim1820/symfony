<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'main_users', function ($i) {
            $user = new User();
            $user ->

        });

        $manager->flush();
    }
}
