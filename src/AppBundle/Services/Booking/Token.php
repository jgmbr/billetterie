<?php

namespace AppBundle\Services\Booking;

use Doctrine\ORM\EntityManagerInterface;

class Token
{
	private $em;
	
	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	} 
	
    public function generateToken($length = 30)
    { 
		$chars 	= "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$token 	= "";
		
		for ($i = 0; $i < $length; $i++) 
		{
			$token .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		
		$booking = $this->em->getRepository('AppBundle:Booking')->findBy(array('token' => $token));
		
		while(count($booking)>0)
		{
			for ($i = 0; $i < $length; $i++) 
			{
				$token .= $chars[mt_rand(0, strlen($chars)-1)];
			}			
			$booking = $this->em->getRepository('AppBundle:Booking')->findBy(array('token' => $token));
		}
		  
		return $token;
    }
}