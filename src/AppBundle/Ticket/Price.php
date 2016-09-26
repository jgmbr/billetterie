<?php

namespace AppBundle\Ticket;

use Doctrine\ORM\EntityManagerInterface;

class Price
{   
	private $em;
	
	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	} 
	
    public function getPrice($age, $conditions = "age")
    {
		if( $age < 0 || !is_int($age))
			return false;
			  
		$listPrices = $this->em->getRepository('AppBundle:Price')->findBy(array('conditions' => $conditions));
	 
		if($conditions=="age")
		{
			foreach($listPrices as $objPrice)
			{
				if($age >= $objPrice->getAgeMin() && $age <= $objPrice->getAgeMax())
				{
					return $objPrice;
				}
			}		
		}else{
			foreach($listPrices as $objPrice)
			{
				return $objPrice;
			}
		}
		
		return $objPrice;
	 
    }
}