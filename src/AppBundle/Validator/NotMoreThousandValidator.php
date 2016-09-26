<?php
// src/AppBundle/Validator/NotMoreThousandValidator.php

namespace AppBundle\Validator;
 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotMoreThousandValidator extends ConstraintValidator
{   
	private $em; 

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}
  
	public function validate($value, Constraint $constraint)
    {  	
		$total = 0;
		
		$datas = $this->context->getRoot()->getData();
		
		$quantity = (int)$datas->getTotalQuantity();
		
		$dateBooking = $datas->getDateBooking();
		
		$listBookings = $this->em->getRepository('AppBundle:Booking')->findBy(array('dateBooking' => $dateBooking));
	
		foreach($listBookings as $row)
		{
			$total += $row->getTotalQuantity();
		}
		
		$total += $quantity;

		if($total>1000)
			$this->context->addViolation($constraint->message);
	 
    }
}
