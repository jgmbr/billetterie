<?php

namespace AppBundle\Ticket;

class Age
{   
    public function getAge(\DateTime $birthDay)
    {
		if ($birthDay instanceof \DateTime) {
			$currentYear 	= new \DateTime('today'); 
			return (int)$birthDay->diff($currentYear)->y;
		}
		return false; 
    }
}