<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;

    private $slug;

    public function __construct()
    {

        $this->faker = Factory::create();
        $this->slug = Slugify::create();
    }


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i < 100; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->text(100));
            $post->setSlug($this->slug->slugify($post->getTitle()));
            $post->setBody($this->faker->text(2500));
            $post->setCreateAt($this->faker->dateTime);

            $manager->persist($post);
        }
        $manager->flush();
    }
}
