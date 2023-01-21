<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Post;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostTest extends KernelTestCase
{
    /** @test */
    public function entity_post_exists(): void
    {
        $post = new Post();
        $this->assertInstanceOf(expected: Post::class, actual: $post,message: 'L\'entité Post n\'existe pas');
    }
    public function getEntityPost(): Post
    {
        $date = new \DateTimeImmutable();
        $post = new Post();
        $post->setTitle(title: 'My First Post');
        $post->setSlug(slug: 'my-first-post');
        $post->setContent(content: 'content');
        $post->setIsPublished(isPublished: false);
        $post->setCreatedAt(createdAt: $date);
        $post->setUpdatedAt(updatedAt: $date->modify(modifier: '+3 days'));
        $post->setPublishedAt(publishedAt: null);

        return $post;
    }
    public function assert_validation_errors_count(Post $entity, int $count): void
    {
        $validator = static::getContainer()->get(ValidatorInterface::class);
        $violations = $validator->validate($entity);

        $messages = [];
        foreach ($violations as $violation) {
            $messages[] =
                'Erreur sur la Propriété '
                . ucfirst($violation->getPropertyPath()) . ' => ' . $violation->getMessage();
        }

        $this->assertCount(
            expectedCount: $count,
            haystack: $violations,
            message: implode(separator:PHP_EOL, array: $messages),
        );
    }
    /** @test */
    public function entity_post_is_valid(): void
    {
        $this->assert_validation_errors_count(entity: $this->getEntityPost(), count: 0);
    }
    /** @test */
    public function title_is_correct(): void
    {
        $post = $this->getEntityPost();
        $post->setTitle(title: 'My title for my post');
        $this->assert_validation_errors_count(entity: $post, count: 0);
    }
    /** @test */
    public function title_is_blank(): void
    {
        $post = $this->getEntityPost();
        $post->setTitle(title: '');

        self::assertEmpty($post->getTitle());
        $this->assert_validation_errors_count(entity: $post, count: 2);
    }
    /** @test */
    public function title_is_too_short(): void
    {
        $post = $this->getEntityPost();
        $post->setTitle(title: 'My');
        $minExpected = 3;
        self::assertLessThan(expected: $minExpected, actual: strlen($post->getTitle()));
        $this->assert_validation_errors_count(entity: $post, count: 1);
    }
    /** @test */
    public function title_is_too_long(): void
    {
        $post = $this->getEntityPost();
        $post->setTitle(title: str_repeat(string: 'a', times: 151));
        $maxExpected = 150;
        self::assertGreaterThan(expected: $maxExpected, actual: strlen($post->getTitle()));
        $this->assert_validation_errors_count(entity: $post, count: 1);
    }
    /** @test */
    public function slug_is_correct(): void
    {
        $post = $this->getEntityPost();
        $slug = str_replace(search: ' ', replace: '-', subject: strtolower($post->getTitle()));
        $post->setSlug(slug: $slug);
        self::assertSame(expected: $slug, actual: $post->getSlug());

        $this->assert_validation_errors_count(entity: $post, count: 0);
    }
    /** @test */
    public function slug_is_blank(): void
    {
        $post = $this->getEntityPost();
        $post->setSlug(slug: '');
        self::assertEmpty($post->getSlug());
        $this->assert_validation_errors_count(entity: $post, count: 1);
    }
    /** @test */
    public function slug_is_too_long(): void
    {
        $post = $this->getEntityPost();
        $maxExpected = 200;
        $post->setSlug(slug: str_repeat(string: 'a', times: $maxExpected + 1));
        self::assertGreaterThan(expected: $maxExpected, actual: strlen($post->getSlug()));
        $this->assert_validation_errors_count(entity: $post, count: 1);
    }
    /** @test */
    public function state_is_DRAFT_by_default_when_post_is_created(): void
    {
        $post = $this->getEntityPost();
        self::assertSame(expected: 'DRAFT', actual: $post->getState());
        $this->assert_validation_errors_count(entity: $post, count: 0);
    }
    /** @test */
    public function state_is_blank(): void
    {
        $post = $this->getEntityPost();
        $post->setState(state: '');
        self::assertEmpty($post->getState());
        $this->assert_validation_errors_count(entity: $post, count: 2);
    }
    /** @test */
    public function state_is_too_long(): void
    {
        $post = $this->getEntityPost();
        $maxExpected = 50;
        $post->setState(state: str_repeat(string: 'a', times: $maxExpected + 1));
        self::assertGreaterThan(expected: $maxExpected, actual: strlen($post->getState()));
        $this->assert_validation_errors_count(entity: $post, count: 2);
    }
    /** @test */
    public function state_is_not_choice_of_STATE(): void
    {
        $post = $this->getEntityPost();
        $post->setState(state: 'test');
        self::assertNotContains(needle: $post->getState(), haystack: Post::STATE);
        $this->assert_validation_errors_count(entity: $post, count: 1);
    }
    /** @test */
    public function state_is_DRAFT(): void
    {
        $post = $this->getEntityPost();
        $post->setState(state: 'DRAFT');
        self::assertSame(expected: 'DRAFT', actual: $post->getState());
        $this->assert_validation_errors_count(entity: $post, count: 0);
    }
    /** @test */
    public function state_is_PUBLISHED(): void
    {
        $post = $this->getEntityPost();
        $post->setState(state: 'PUBLISHED');
        self::assertSame(expected: 'PUBLISHED', actual: $post->getState());
        $this->assert_validation_errors_count(entity: $post, count: 0);
    }
    /** @test */
    public function state_is_ARCHIVED(): void
    {
        $post = $this->getEntityPost();
        $post->setState(state: 'ARCHIVED');
        self::assertSame(expected: 'ARCHIVED', actual: $post->getState());
        $this->assert_validation_errors_count(entity: $post, count: 0);
    }
    /** @test */
    public function content_is_blank(): void
    {
        $post = $this->getEntityPost();
        $post->setContent(content: '');
        self::assertEmpty($post->getContent());
        $this->assert_validation_errors_count(entity: $post, count: 1);
    }



}
