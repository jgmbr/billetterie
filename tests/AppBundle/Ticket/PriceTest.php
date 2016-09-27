<?php

namespace Tests\AppBundle\Ticket;

use AppBundle\Ticket\Price;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PriceTest extends WebTestCase
{
    private $em;

    public function __construct()
    {
        $kernelNameClass = $this->getKernelClass();
        $kernel = new $kernelNameClass('test', true);
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testGetPrice()
    {
        $price = new Price($this->em);

        $result1 = $price->getPrice(2, "age");

        $this->assertEquals(0, $result1->getPrice());

        $result2 = $price->getPrice(7, "age");

        $this->assertEquals(8, $result2->getPrice());

        $result3 = $price->getPrice(26, "age");

        $this->assertEquals(16, $result3->getPrice());

        $result4 = $price->getPrice(65, "age");

        $this->assertEquals(12, $result4->getPrice());

        $result5 = $price->getPrice(18, "reduction");

        $this->assertEquals(10, $result5->getPrice());
    }

}