<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    protected $client;
    protected $crawler;
    protected $form;
    protected $value;

    protected function setUp()
    {
        $kernelNameClass = $this->getKernelClass();
        $kernel = new $kernelNameClass('test', true);
        $kernel->boot();
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertContains('2016 - Musée du Louvre', $client->getResponse()->getContent());

        $this->assertCount(1, $crawler->filter('h1'));
    }

}
