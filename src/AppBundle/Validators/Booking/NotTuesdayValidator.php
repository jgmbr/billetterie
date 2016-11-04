<?php
// src/AppBundle/Validators/Booking/NotTuesdayValidator.php

namespace AppBundle\Validators\Booking;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotTuesdayValidator extends ConstraintValidator
{   
    public function validate($value, Constraint $constraint)
    {    
        if (!$value instanceof \DateTime){
            $value = new \DateTime($value);
        } 

        $timestamp = $value->getTimestamp(); 
		
		$day = (int)date("w",$timestamp);
		  
		if( $day == 2 ) {
			$this->context->addViolation($constraint->message);
		}	 
    }
}
