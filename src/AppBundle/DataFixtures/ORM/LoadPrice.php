<?php
// src/AppBundle/DataFixtures/ORM/LoadPrice.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Price;

class LoadPrice implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$price1 = new Price();
		$price1->setCode('BEB');
		$price1->setAgeMin(0);
		$price1->setAgeMax(3);
		$price1->setPrice(0);
		$price1->setConditions('age');
		$price1->setNameFr('Bébé');
		$price1->setSlugFr('bebe');
		$price1->setNameEn('Baby');
		$price1->setSlugEn('baby');
		$price1->setInfosFr('jusqu\'à 3 ans');
		$price1->setInfosEn('up to 3 years');
		$manager->persist($price1);
		 
		$price2 = new Price();
		$price2->setCode('ENF');
		$price2->setAgeMin(4);
		$price2->setAgeMax(11);
		$price2->setPrice(8);
		$price2->setConditions('age');
		$price2->setNameFr('Enfant');
		$price2->setSlugFr('enfant');
		$price2->setNameEn('Child');
		$price2->setSlugEn('child');
		$price2->setInfosFr('à partir de 4 ans');
		$price2->setInfosEn('from 4 years');
		$manager->persist($price2);
		
		$price3 = new Price();
		$price3->setCode('NOR');
		$price3->setAgeMin(12);
		$price3->setAgeMax(59);
		$price3->setPrice(16);
		$price3->setConditions('age');
		$price3->setNameFr('Normal');
		$price3->setSlugFr('normal');
		$price3->setNameEn('Normal');
		$price3->setSlugEn('normal');
		$price3->setInfosFr('à partir de 12 ans');
		$price3->setInfosEn('from 12 years');
		$manager->persist($price3);
		 		
		$price4 = new Price();
		$price4->setCode('SEN');
		$price4->setAgeMin(60);
		$price4->setAgeMax(999);
		$price4->setPrice(12);
		$price4->setConditions('age');
		$price4->setNameFr('Senior');
		$price4->setSlugFr('senior');
		$price4->setNameEn('Senior');
		$price4->setSlugEn('senior');
		$price4->setInfosFr('à partir de 60 ans');
		$price4->setInfosEn('from 60 years');
		$manager->persist($price4);		
 		
		$price5 = new Price();
		$price5->setCode('RED');
		$price5->setAgeMin(0);
		$price5->setAgeMax(999);
		$price5->setPrice(10);
		$price5->setConditions('reduction');
		$price5->setNameFr('Réduit');
		$price5->setSlugFr('reduit');
		$price5->setNameEn('Reduced');
		$price5->setSlugEn('reduced');
		$price5->setInfosFr('sur présentation de la carte d\'étudiant, militaire ou équivalent lors de l\'entrée au Musée');
		$price5->setInfosEn('on presentation of a student card, military or equivalent at the Museum admission');
		$manager->persist($price5);
		 
		$manager->flush();
	}
	
	public function getOrder()
	{ 
		return 1;
	}
}
