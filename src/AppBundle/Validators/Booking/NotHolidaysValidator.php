<?php
// src/AppBundle/Validators/Booking/NotHolidaysValidator.php

namespace AppBundle\Validators\Booking;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotHolidaysValidator extends ConstraintValidator
{  
	public function getHolidays($year = null)
	{
		if ($year === null)
		{
			$year = intval(date('Y'));
		}

		$holidays = array( 
			mktime(0, 0, 0, 5,  1,  $year), // 1er mai
			mktime(0, 0, 0, 11, 1,  $year), // 1er novembre
			mktime(0, 0, 0, 12, 25, $year), // 25 décembre
		);

		sort($holidays);

		return $holidays;
	}

    public function validate($value, Constraint $constraint)
    {
        $holidays = $this->getHolidays((int)$value->format('Y'));

        if (!$value instanceof \DateTime){
            $value = new \DateTime($value);
        } 

        $timestamp = $value->getTimestamp();

		if (in_array($timestamp, $holidays)) {
			$this->context->addViolation($constraint->message);
		}  
    }
}
