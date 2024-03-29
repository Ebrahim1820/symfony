<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Tag;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends BaseFixture //implements DependentFixtureInterface
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

            // /** @var Tag[] $tags */
            // $tags = $this->getRandomReferences(Tag::class, $this->faker->numberBetween(0, 5));
           
            // foreach($tags as $tag){
            //     $comment->addTag($tag);
            // }
            // die();
            // These two lins will save object
            // persist-> it will tell to doctrine to be aware of comment object
            //$manager->persist($comment);


        });
            // flush-> tell to doctrin, look at the object that aware of and make all queries 
            // you need to save those.
            $manager->flush();
    }

    // public function getDependencies()
    // {
    //     return [
    //         TagFixture::class,
    //     ];
    // }

    ////////////////////////////////////////////////////

    $this->createMany(10, 'main_articles', function($count) use ($manager) {
        $comment = new Comment();
        $article->setTitle($this->faker->randomElement(self::$articleTitles))
            ->setContent(<<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
**turkey** shank eu pork belly meatball non cupim.

Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.

Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF
        );

        // publish most articles
        if ($this->faker->boolean(70)) {
            $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
        }

        $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
            ->setHeartCount($this->faker->numberBetween(5, 100))
            ->setImageFilename($this->faker->randomElement(self::$articleImages))
        ;

        $tags = $this->getRandomReferences('main_tags', $this->faker->numberBetween(0, 5));
        foreach ($tags as $tag) {
            $article->addTag($tag);
        }

        return $article;
    });

    $manager->flush();
}

public function getDependencies()
{
    return [
        TagFixture::class,
    ];
}
}
