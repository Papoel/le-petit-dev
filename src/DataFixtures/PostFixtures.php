<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($postNumber = 1; $postNumber <= 10; $postNumber++) {
            $post = new Post();
            $post->setTitle(title: sprintf('Mon super article %d', $postNumber));
            $post->setSlug(slug: sprintf('mon-super-article-%d', $postNumber));
            $post->setContent(content: sprintf('Contenu de mon super article %d', $postNumber));

            $manager->persist($post);
        }
        $manager->flush();
    }
}
