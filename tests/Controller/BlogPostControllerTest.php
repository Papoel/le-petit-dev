<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BlogPostControllerTest extends WebTestCase
{
    /** @test */
    public function the_home_page_route_exists(): void
    {
        $client = static::createClient();
        self::assertNotNull(actual:
            $client->getContainer()
            ->get(id: 'router')
            ->getRouteCollection()
            ->get('app_homepage'),
            message: 'La route "app_homepage" n\'existe pas.'
        );
    }

    /** @test */
    public function the_home_page_is_display(): void
    {
        $client = static::createClient();
        $client->request(
            method: Request::METHOD_GET,
            uri: $client->getContainer()
                ->get(id: 'router')
                ->generate(name: 'app_homepage', referenceType: UrlGeneratorInterface::ABSOLUTE_URL)
        );

         self::assertResponseIsSuccessful();
         self::assertResponseStatusCodeSame(expectedCode: Response::HTTP_OK);
         self::assertSelectorTextContains(
             selector: 'h1',
             text: 'Le Petit Dev',
             message: 'Le titre de la page d\'accueil n\'est pas correct.'
         );
    }
    /** @test */
    public function the_home_page_contains_the_navbar(): void
    {
        $client = static::createClient();
        $client->request(
            method: Request::METHOD_GET,
            uri: $client->getContainer()
                ->get(id: 'router')
                ->generate(name: 'app_homepage', referenceType: UrlGeneratorInterface::ABSOLUTE_URL)
        );

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(expectedCode: Response::HTTP_OK);
        self::assertSelectorTextContains(selector: '.link_to_home', text: 'Accueil');
        self::assertSelectorTextContains(selector: '.link_to_articles', text: 'Articles');
        self::assertSelectorTextContains(selector: '.link_to_about', text: 'A Propos');
    }

    /** @test */
    public function the_navbar_contains_toggle_dark_mode(): void
    {
        $client = static::createClient();
        $client->request(
            method: Request::METHOD_GET,
            uri: $client->getContainer()
                ->get(id: 'router')
                ->generate(name: 'app_homepage', referenceType: UrlGeneratorInterface::ABSOLUTE_URL)
        );

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(expectedCode: Response::HTTP_OK);
        self::assertSelectorTextContains(selector: '#dark_mode', text: '🌞 🌛');
    }

    /** @test */
    public function the_title_is_not_inherited_from_the_base_template(): void
    {
        $client = static::createClient();
        $client->request(
            method: Request::METHOD_GET,
            uri: $client->getContainer()
                ->get(id: 'router')
                ->generate(name: 'app_homepage', referenceType: UrlGeneratorInterface::ABSOLUTE_URL)
        );

        $crawler = $client->getCrawler();
        $title = $crawler->filter(selector: 'title')->text();
        $titleFromBase = 'Papoel |';

        self::assertNotSame(
            expected: $titleFromBase,
            actual: $title,
            message: 'Le titre de la page est incorrect'
        );
    }

    /** @test */
    public function page_contains_the_footer(): void
    {
        $client = static::createClient();
        $client->request(
            method: Request::METHOD_GET,
            uri: $client->getContainer()
                ->get(id: 'router')
                ->generate(name: 'app_homepage', referenceType: UrlGeneratorInterface::ABSOLUTE_URL)
        );

        // S'assurer que le "footer" existe sur la page
        self::assertSelectorExists(selector: 'footer', message: 'Le footer n\'existe pas sur la page d\'accueil.');
    }
}
