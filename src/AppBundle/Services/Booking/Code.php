<?php

namespace AppBundle\Services\Booking;

use Doctrine\ORM\EntityManagerInterface;

class Code
{
	private $em;
	
	private $prefixe;
	
	public function __construct(EntityManagerInterface $em)
	{
		$this->em 		= $em;
		$this->prefixe 	= "BC-";
	} 
	
    public function generateCode($length = 10)
    { 
		$chars 	= "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$code 	= "";
		
		for ($i = 0; $i < $length; $i++) 
		{
			$code .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		
		$booking = $this->em->getRepository('AppBundle:Booking')->findBy(array('codeBooking' => $code));
		
		while(count($booking)>0)
		{
			for ($i = 0; $i < $length; $i++) 
			{
				$code .= $chars[mt_rand(0, strlen($chars)-1)];
			}
			$booking = $this->em->getRepository('AppBundle:Booking')->findBy(array('codeBooking' => $code));
		}
		  
		return $this->prefixe.$code;
    }
}