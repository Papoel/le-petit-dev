<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
       $client->request(method: Request::METHOD_GET, uri: '/');

         self::assertResponseIsSuccessful();
         self::assertResponseStatusCodeSame(expectedCode: Response::HTTP_OK);
         self::assertSelectorTextContains(selector: 'h1', text: 'Le Petit Dev');
    }
}
