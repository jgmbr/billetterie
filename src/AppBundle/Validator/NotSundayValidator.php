<?php
// src/AppBundle/Validator/NotSundayValidator.php

namespace AppBundle\Validator;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotSundayValidator extends ConstraintValidator
{   
    public function validate($value, Constraint $constraint)
    {    
        if (!$value instanceof \DateTime){
            $value = new \DateTime($value);
        }

        $timestamp = $value->getTimestamp(); 
		
		$day = (int)date("w",$timestamp);
		  
		if( $day == 0 ) {
			$this->context->addViolation($constraint->message);
		}	 
    }
}
