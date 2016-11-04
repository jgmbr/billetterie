<?php
// src/AppBundle/Validators/Booking/NotPreviousDayValidator.php

namespace AppBundle\Validators\Booking;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotPreviousDayValidator extends ConstraintValidator
{  
    public function validate($value, Constraint $constraint)
    {     
        if (!$value instanceof \DateTime){
            $value = new \DateTime($value);
        } 
		 
        $timestamp = $value->getTimestamp();
		 
		$currentDay = new \DateTime('today midnight');
		
		$currentDay = $currentDay->getTimestamp();
		  
		if($timestamp<$currentDay) {
			$this->context->addViolation($constraint->message);
		} 
    }
}
