<?php
// src/AppBundle/Validators/Booking/NotHolidays.php

namespace AppBundle\Validators\Booking;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotHolidays extends Constraint
{
	public $message = "Vous ne pouvez pas commander un billet un jour férié";
	
	public function validatedBy()
	{
		return 'app_louvre_notholidays';
	}
} 