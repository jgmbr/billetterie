<?php

namespace Tests\AppBundle\Ticket;

use AppBundle\Services\Ticket\Age;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AgeTest extends WebTestCase
{
    public function testGetAge()
    {
        $age = new Age();

        $result1 = $age->getAge(new \DateTime('1990-01-16'));

        $this->assertEquals(26, $result1);

        $result2 = $age->getAge(new \DateTime('2008-01-21'));

        $this->assertEquals(8, $result2);

        $result3 = $age->getAge(new \DateTime('1957-01-30'));

        $this->assertEquals(59, $result3);
    }
}