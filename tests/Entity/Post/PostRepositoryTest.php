<?php

declare(strict_types=1);

namespace App\Tests\Entity\Post;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Repository\PostRepository;

class PostRepositoryTest extends KernelTestCase
{
    /** @test */
    public function count_posts_in_database(): void
    {
        self::bootKernel();
        $postRepository = self::getContainer()->get(PostRepository::class);
        $posts = $postRepository->count([]);

        self::assertEquals(10, $posts);
    }
    /** @test */
    public function count_posts_in_database_with_criteria(): void
    {
        self::bootKernel();
        $postRepository = self::getContainer()->get(PostRepository::class);
        $posts = $postRepository->count(['title' => 'Mon super article 4']);

        self::assertEquals(1, $posts, 'Le nombre d\'articles attendues ne correspond pas.');
    }

    /** @test */
    public function check_if_preUpdate_is_called_and_if_updatedAt_is_really_updated(): void
    {
        self::bootKernel();
        $postRepository = self::getContainer()->get(PostRepository::class);
        $post = $postRepository->findOneBy(['title' => 'Mon super article 4']);
        $post->setTitle('Mon super nouvel article 4');
        $postRepository->save($post, true);
        $post = $postRepository->findOneBy(['title' => 'Mon super nouvel article 4']);
        $updatedAt = $post->getUpdatedAt();

        self::assertNotNull($updatedAt);
    }
}
