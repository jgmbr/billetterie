<?php
// src/AppBundle/DataFixtures/ORM/LoadTicketType.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\TicketType;

class LoadTicketType implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$ticketType1 = new TicketType();
		$ticketType1->setNameFr('Journée');
		$ticketType1->setNameEn('Day');
		$ticketType1->setImpact(0);
		$ticketType1->setConditions('< 02:00 pm');
		$manager->persist($ticketType1);
		
		$ticketType2 = new TicketType();
		$ticketType2->setNameFr('Demi-journée');
		$ticketType2->setNameEn('Half day');
		$ticketType2->setImpact(0.5);
		$manager->persist($ticketType2);
		
		$manager->flush();
	}
	
	public function getOrder()
	{ 
		return 2;
	}
}
