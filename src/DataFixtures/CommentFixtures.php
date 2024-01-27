<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends BaseFixture
{

    private static $commentTitle = [
        'Why Asteroids Taste Like Bacon',
        'Life on Planet Mercury: Tan, Relaing and Fabulous',
        'Light speed Travel:',
    ];
    private static $commentImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];

    private static $commentAuthors = [
        'Ebrahim Najafi',
        'Amy Oort',
        'Mike Ferengi',
    ];




   protected function loadData(ObjectManager $manager) 
    {
        $this->createMany(Comment::class, 10, function(Comment $comment, $count) use ($manager)  {

            $comment->setName($this->faker->randomElement(self::$commentTitle))
                // ->setSlug('Why-Asteroids-Taste-Like-Baco-'.$count)
                ->setComment(
                    <<<EDF
            'PostgreSQL ist eine objektrelationale Datenbank, 
            die sowohl relationale Datenbankfunktionen als auch NoSQL-Funktionen 
            zur Abfrage unstrukturierter Daten enthält. Wählen Sie PostgreSQL,
             wenn Sie komplexe Prozeduren und Designs,
             Integrationen und Datenintegrität benötigen.
            '
            EDF
                );

            //publish some articles 
            if ($this->faker->boolean(70)) {
                $comment->setCommentedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));

            }
            $comment->setAuthor($this->faker->randomElement(self::$commentAuthors))
                ->setHeartCount($this->faker->numberBetween(5, 100))
                ->setImageFileName($this->faker->randomElement(self::$commentImages));

          

            // These two lins will save object
            // persist-> it will tell to doctrine to be aware of comment object
            //$manager->persist($comment);


        });
            // flush-> tell to doctrin, look at the object that aware of and make all queries 
            // you need to save those.
            $manager->flush();
    }
}
