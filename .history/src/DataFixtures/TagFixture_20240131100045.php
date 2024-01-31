<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends BaseFixture
{

    // protected  function loadData(ObjectManager $manager)
    // {
    //     $this->createMany(Tag::class, 10, function (Tag $tag) {
    //         $tag->setName($this->faker->realText(20));
    //     });

    //     $manager->flush();
    // }

    ////////////////////////////////////
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_tags', function() {
            $tag = new Tag();
            $tag->setName($this->faker->realText(20));

            return $tag;
        });

        $manager->flush();
    }
}
