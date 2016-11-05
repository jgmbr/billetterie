<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Services\Booking\Code;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingControllerTest extends WebTestCase
{
    protected $client;
    protected $crawler;
    protected $form;
    protected $value;
    protected $em;
    protected $code;

    protected function setUp()
    {
        $kernelNameClass = $this->getKernelClass();
        $kernel = new $kernelNameClass('test', true);
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $code = new Code($this->em);
        $this->code = $code->generateCode();
        $this->code = "BC-3KEQZS0K8O";
    }

    public function testCancel()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/checkout');

        $link = $crawler
            ->filter('a:contains("Annuler ma commande")')
            ->eq(0)
            ->link();

        $crawler = $client->click($link);

        $this->assertTrue($client->getResponse()->isSuccessful());

    }

    public function testCheckout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/');

        $link = $crawler
            ->filter('a:contains("Billetterie")')
            ->eq(0)
            ->link()
        ;

        $crawler = $client->click($link);

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertCount(5, $crawler->filter('#order_step > li'));

        $form = $crawler->selectButton('booking_save')->form();

        $crawler = $client->request(
            $form->getMethod(),
            $form->getUri(),
            array(
                "booking" =>
                    array(
                        "date_booking" => "2020-01-16",
                        "total_quantity" => 1,
                        "email" => "gambier.j@gmail.com",
                        "ticketType" => 11
                    )
            ),
            $form->getPhpFiles()
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testInformations()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/informations/'.$this->code, array(), array(), array());

        $this->assertTrue($client->getResponse()->isSuccessful());

        $form = $crawler->selectButton('information_save')->form();

        $crawler = $client->request(
            $form->getMethod(),
            $form->getUri(),
            array(
                "information" =>
                    array(
                        "ticket" =>
                            array(
                                0 =>
                                    array(
                                        "lastname" => "Gambier",
                                        "firstname" => "Justine",
                                        "country" => "FR",
                                        "birthday" => "1990-01-16",
                                        "reduction" => false
                                    )
                            )
                    )
            ),
            $form->getPhpFiles()
        );
    }

    public function testPayment()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/payment/'.$this->code, array(), array(), array());

        $this->assertTrue($client->getResponse()->isSuccessful());

        // if tickets rows

        $this->assertGreaterThan(
            0,
            $crawler->filter('#table_summary > tbody > tr')->count()
        );
    }

}
