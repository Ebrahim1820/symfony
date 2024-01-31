<?php

namespace App\DataFixtures;


use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixture extends BaseFixture 
{
    // protected function loadData(ObjectManager $manager)
    // {
    //     $this->createMany(Post::class, 100, function (Post $post) {
    //         $text =  $this->faker->boolean ? $this->faker->address :$this->faker->address();
           
    //         $post->setContent(
    //             $text
    //         );
            

    //         $post->setAuthorName($this->faker->name);
    //         $post->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));

    //         $post->setComment($this->getReference(Comment::class .'_'.$this->faker->numberBetween(0, 9)));
    //         $post->setIsDeleted($this->faker->boolean(20));

    //         //$post->setComment($this->getRandomReference(Comment::class));
    //     });
       

    //     $manager->flush();
    // }

    // public function getDependencies(){

    //     // CommentFixtures::class;
    // }

    
}
